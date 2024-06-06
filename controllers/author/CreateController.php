<?php

namespace app\controllers\author;

use app\models\Tables\AccessToBook;
use app\models\Tables\BookCharacter;
use app\models\Tables\BookFandom;
use app\models\Tables\BookGenre;
use app\models\Tables\BookOrigin;
use app\models\Tables\BookTag;
use app\models\Tables\Character;
use app\models\Tables\Fandom;
use app\models\Tables\Genre;
use app\models\Tables\GenreType;
use app\models\Tables\Origin;
use app\models\Tables\Pairing;
use app\models\Tables\PairingCharacter;
use app\models\Tables\PublicEditing;
use app\models\Tables\Rating;
use app\models\Tables\Relation;
use app\models\Tables\Relationship;
use app\models\Tables\Size;
use app\models\Tables\Tag;
use app\models\Tables\TagType;
use app\models\Tables\Type;
use app\models\Tables\Book;
use app\models\Tables\User;
use PHPUnit\Exception;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class CreateController extends Controller
{
    public function actionNewBook() {
        $session = Yii::$app->session;
        $step = $session->has('step') ? $session->get('step') : 'main';
        $allow = $this->checkAllow();

        return $this->render('new-book', [
            'step' => $step,
            'allow' => $allow,
        ]);
    }


    // вспомогательные функции
    public function actionLoadStepMain() {
        $session = Yii::$app->session;
        $session->set('step', 'main');

        // получение данных от пользователя
        $create_title = $session->get('create.title');
        $create_description = $session->get('create.description');
        $create_remark = $session->get('create.remark');
        $create_disclaimer = $session->get('create.disclaimer');
        $create_dedication = $session->get('create.dedication');

        $create_relation = $session->get('create.relation');
        $create_rating = $session->get('create.rating');
        $create_plan_size = $session->get('create.plan_size');

        $sort_genres = $this->findAndSortMeta($session->get('create.genres'), Genre::class);
        $sort_tags = $this->findAndSortMeta($session->get('create.tags'), Tag::class);

        // данные для автоматической загрузки в поля и прочее
        $relations = Relation::find()->all();
        $ratings = Rating::find()->all();
        $plan_sizes = Size::find()->all();

        $genre_types = GenreType::find()->all();
        $tag_types = TagType::find()->where(['<>', 'id', 6])->all(); // исключает фэндомные теги


        return $this->renderAjax('steps/step1_main', [
            // данные как из формы
            'create_title' => $create_title,
            'create_description' => $create_description,
            'create_remark' => $create_remark,
            'create_disclaimer' => $create_disclaimer,
            'create_dedication' => $create_dedication,

            'create_relation' => $create_relation,
            'create_rating' => $create_rating,
            'create_plan_size' => $create_plan_size,

            'create_genres' => $sort_genres,
            'create_tags' => $sort_tags,

            // прочие данные
            'relations' => $relations,
            'ratings' => $ratings,
            'plan_sizes' => $plan_sizes,

            'genre_types' => $genre_types,
            'tag_types' => $tag_types,
        ]);
    }
    public function actionLoadStepFandom() {
        $session = Yii::$app->session;
        $session->set('step', 'fandom');

        // субъективные данные
        $create_book_type = $session->get('create.book_type');
        $sort_fandoms = $this->findAndSortMeta($session->get('create.fandoms'), Fandom::class);
        $create_origins = $session->get('create.origins');
        $create_characters = $this->findAndSortMeta($session->get('create.characters'), Character::class);
        $create_fandom_tags = $this->findAndSortMeta($session->get('create.fandom_tags'), Tag::class);

        $create_pairings = $session->get('create.pairings');
        $pairings_info = [];
        if ($create_pairings)
            foreach ($create_pairings as $create_pairing) {
                $pairings_info[] = [
                    'relationship' => Relationship::findOne($create_pairing['relationship']),
                    'characters' => Character::find()->where(['id' => $create_pairing['characters']])->all()
                ];
            }

        //объективные данные
        $book_types = Type::find()->all();
        $relationships = Relationship::find()->all();

        return $this->renderAjax('steps/step2_fandom', [
            // субъективные
            'create_book_type' => $create_book_type,
            'create_fandoms' => $sort_fandoms,
            'create_origins' => $create_origins,
            'create_characters' => $create_characters,
            'create_fandom_tags' => $create_fandom_tags,
            'create_pairings' => $pairings_info,
            // объективные
            'book_types' => $book_types,
            'relationships' => $relationships,
        ]);
    }
    public function actionLoadStepCover() {
        $session = Yii::$app->session;
        $session->set('step', 'cover');

        $create_cover = $session->get('create.cover');

        return $this->renderAjax('steps/step3_cover', [
            'create_cover' => $create_cover
        ]);
    }
    public function actionLoadStepAccess() {
        $session = Yii::$app->session;
        $session->set('step', 'access');

        // пользовательские данные
        $create_public_editing = $session->get('create.public_editing');
        $create_coauthor = User::findOne($session->get('create.coauthor'));
        $create_beta = User::findOne($session->get('create.beta'));
        $create_gamma = User::findOne($session->get('create.gamma'));


        // автоматические, объективные данные
        $public_editing = PublicEditing::find()->all();

        return $this->renderAjax('steps/step4_access', [
            // субъективные
            'create_public_editing' => $create_public_editing,
            'create_coauthor' => $create_coauthor,
            'create_beta' => $create_beta,
            'create_gamma' => $create_gamma,
            // объективные
            'public_editing' => $public_editing,
        ]);
    }


    public function actionUploadCover() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $image = UploadedFile::getInstanceByName('cropped_image');
        if ($image) {
            $name = uniqid() . '.png';
            $path = 'images/covers/uploads/' . $name;
            if ($image->saveAs($path)) {
                $session->set('create.cover', $name);
                return ['url' => $path];
            }
        }
        return $image->extension;
    }
    public function actionRemoveCover() {
        $session = Yii::$app->session;
        $cover = $session->get('create.cover');
        if ($cover)
            if (file_exists($cover)) unlink('images/covers*uploads/' . $cover); // удаляет файл с сервера, если таковой существует
        $session->set('create.cover', '');
    }



    public function actionSaveData() {
        $session = Yii::$app->session;
        $session_key = Yii::$app->request->post('session_key');
        $data = Yii::$app->request->post('data');
        $is_array = Yii::$app->request->post('is_array');
        if ($is_array !== 'false') {
            $temp = $session->get('create.' . $session_key);
            if (!$temp) $temp = [];
            $key = array_search($data, $temp);
            if ($key !== false) unset($temp[$key]);
            else $temp[] = $data;
            $session->set('create.' . $session_key, $temp);
        }
        else {
            if ($session_key == 'coauthor' || $session_key == 'beta' || $session_key == 'gamma') {
                if ($session->get('create.' . $session_key) == $data) $session->remove('create.' . $session_key);
                else $session->set('create.' . $session_key, $data);
            }
            else $session->set('create.' . $session_key, $data);
        }

    }

    public function actionSaveBook() {
        $session = Yii::$app->session;
        $user = Yii::$app->user->identity;

        $title = $session->get('create.title');
        $description = $session->get('create.description');
        $remark = $session->get('create.remark');
        $disclaimer = $session->get('create.disclaimer');
        $dedication = $session->get('create.dedication');
        $relation = $session->get('create.relation');
        $rating = $session->get('create.rating');
        $plan_size = $session->get('create.plan_size');
        $genres = $session->get('create.genres');
        $tags = $session->get('create.tags');

        $book_type = $session->get('create.book_type');
        $fandoms = $session->get('create.fandoms');
        $origins = $session->get('create.origins');
        $characters = $session->get('create.characters');
        $pairings = $session->get('create.pairings');
        $fandom_tags = $session->get('create.fandom_tags');

        $cover = $session->get('create.cover');

        $public_editing = $session->get('create.public_editing');
        $coauthor = $session->get('create.coauthor');
        $beta = $session->get('create.beta');
        $gamma = $session->get('create.gamma');

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // КНИГА
            $book = new Book();
            $book->user_id = $user->id;
            $book->created_at = new Expression('NOW()');
            $book->is_draft = 1;
            $book->is_perfect = 0;
            $book->public_editing_id = $public_editing;
            $book->title = $title;
            $book->cover = $cover;
            $book->description = $description;
            $book->remark = $remark;
            $book->dedication = $dedication;
            $book->disclaimer = $disclaimer;
            $book->type_id = $book_type;
            $book->rating_id = $rating;
            $book->completeness_id = 1;
            $book->relation_id = $relation;
            $book->plan_size_id = $plan_size;
            $book->real_size_id = null; // потому что нет никакого размера
            if (!$book->save()) throw new \Exception('Не удалось сохранить книгу');
            
            // ЖАНРЫ
            if ($genres)
                foreach ($genres as $genre) {
                    $book_genre = new BookGenre();
                    $book_genre->book_id = $book->id;
                    $book_genre->genre_id = $genre;
                    if (!$book_genre->save()) throw new \Exception('Не удалось сохранить жанры');
                }

            // ТЕГИ
            if ($tags)
                foreach ($tags as $tag) {
                    $book_tag = new BookTag();
                    $book_tag->book_id = $book->id;
                    $book_tag->tag_id = $tag;
                    if (!$book_tag->save()) throw new \Exception('Не удалось сохранить теги');
                }

            // ФЭНДОМЫ
            if ($fandoms)
                foreach ($fandoms as $fandom) {
                    $book_fandom = new BookFandom();
                    $book_fandom->book_id = $book->id;
                    $book_fandom->fandom_id = $fandom;
                    if (!$book_fandom->save()) throw new \Exception('Не удалось сохранить фэндомы');
                }

            // ПЕРВОИСТОЧНИКИ
            if ($origins)
                foreach ($origins as $origin) {
                    $book_origin = new BookOrigin();
                    $book_origin->book_id = $book->id;
                    $book_origin->origin_id = $origin;
                    if (!$book_origin->save()) throw new \Exception('Не удалось сохранить первоисточники');
                }

            // ПЕРСОНАЖИ
            if ($characters)
                foreach ($characters as $character) {
                    $book_character = new BookCharacter();
                    $book_character->book_id = $book->id;
                    $book_character->character_id = $character;
                    if (!$book_character->save()) throw new \Exception('Не удалось сохранить персонажей');
                }

            // ПЕЙРИНГИ
            if ($pairings)
                foreach ($pairings as $pairing) {
                    $pairing_db = new Pairing();
                    $pairing_db->book_id = $book->id;
                    $pairing_db->relationship_id = $pairing['relationship'];
                    if (!$pairing_db->save()) throw new \Exception('Не удалось сохранить пейринг');

                    foreach ($pairing['characters'] as $character) {
                        $pairing_character = new PairingCharacter();
                        $pairing_character->character_id = $character;
                        $pairing_character->pairing_id = $pairing_db->id;
                        if (!$pairing_character->save()) throw new \Exception('Не удалось сохранить персонажей пейринга');
                    }
                }

            // ФЭНДОМНЫЕ ТЕГИ
            if ($fandom_tags)
                foreach ($fandom_tags as $fandom_tag) {
                    $book_fandom_tag = new BookTag();
                    $book_fandom_tag->book_id = $book->id;
                    $book_fandom_tag->tag_id = $fandom_tag;
                    if (!$book_fandom_tag->save()) throw new \Exception('Не удалось сохранить фэндомные теги');
                }

            // ДОСТУП
            if ($coauthor || $beta || $gamma) {
                $access_to_book = new AccessToBook();
                $access_to_book->book_id = $book->id;
                $access_to_book->coauthor_id = $coauthor;
                $access_to_book->beta_id = $beta;
                $access_to_book->gamma_id = $gamma;
                if (!$access_to_book->save()) throw new \Exception('Не удалось сохранить пользователей доступа');
            }

            $transaction->commit();
            $this->deleteAll();
            $session->set('modify.book.tab', 'chapters');
            $session->set('modify.book', $book->id);
            return $this->redirect(Url::toRoute(['author/modify/book']));
        }
        catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
    public function actionDeleteAll() {
        $this->deleteAll();
        return $this->redirect(Url::to(['author/author-panel/books-dashboard']));
    }

    public function deleteAll() {
        $session = Yii::$app->session;

        $session->remove('step');

        $session->remove('create.title');
        $session->remove('create.description');
        $session->remove('create.remark');
        $session->remove('create.disclaimer');
        $session->remove('create.dedication');
        $session->remove('create.relation');
        $session->remove('create.rating');
        $session->remove('create.plan_size');
        $session->remove('create.genres');
        $session->remove('create.tags');

        $session->remove('create.book_type');
        $session->remove('create.fandoms');
        $session->remove('create.origins');
        $session->remove('create.characters');
        $session->remove('create.pairings');
        $session->remove('create.fandom_tags');

        $cover = $session->get('create.cover');
        if ($cover)
            if (file_exists($cover)) unlink($cover); // удаляет файл с сервера, если таковой существует
        $session->remove('create.cover');

        $session->remove('create.public_editing');
        $session->remove('create.coauthor');
        $session->remove('create.beta');
        $session->remove('create.gamma');
    }

    public function  actionCheckAllow() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['allow' => $this->checkAllow()];
    }
    public function checkAllow() {
        $session = Yii::$app->session;
        $allow = true;

        // общая информация
        if (!$session->has('create.title') || $session->get('create.title') == '') $allow = false;
        if (!$session->has('create.description') || $session->get('create.description') == '') $allow = false;
        if (!$session->has('create.relation') || $session->get('create.relation') == '') $allow = false;
        if (!$session->has('create.rating') || $session->get('create.rating') == '') $allow = false;
        if (!$session->has('create.plan_size') || $session->get('create.plan_size') == '') $allow = false;

        // фэндомные сведения
        if (!$session->has('create.book_type') || $session->get('create.book_type') == '') $allow = false;
        else if ($session->get('create.book_type') == 2) {
            if (!$session->has('create.fandoms') || $session->get('create.fandoms') == []) $allow = false;
        }

        // доступ
        if (!$session->has('create.public_editing') || $session->get('create.public_editing') == '') $allow = false;

        return  $allow;
    }



    public function actionSavePairing() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $session = Yii::$app->session;
        $data_type = Yii::$app->request->post('data_type');
        $item_id = (int)Yii::$app->request->post('id');
        $pairing_id = Yii::$app->request->post('pairing');

        $pairings = $session->get('create.pairings');

        if ($data_type == 'characters') $pairings[$pairing_id][$data_type][] = $item_id;
        else if ($data_type == 'relationship') $pairings[$pairing_id][$data_type] = $item_id;

        $session->set('create.pairings', $pairings);
    }
    public function actionDeletePairing() {
        $session = Yii::$app->session;
        $remove = Yii::$app->request->post('remove');
        $pairing = Yii::$app->request->post('pairing_id');
        if ($remove == 'character') {
            $character = Yii::$app->request->post('character_id');
            $pairings = $session->get('create.pairings');
            if ($pairings[$pairing]) {
                $key = array_search($character, $pairings[$pairing]['characters']);
                if ($key !== false) unset($pairings[$pairing]['characters'][$key]);
            }
            $session->set('create.pairings', $pairings);
        }
        else if ($remove == 'pairing') {
            $pairings = $session->get('create.pairings');
            if ($pairings[$pairing]) unset($pairings[$pairing]);
            $session->set('create.pairings', $pairings);
        }
    }
    public function actionRemoveFandomDepend() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $fandom = Yii::$app->request->post('fandom_id');
        if ($fandom) {
            $origins = $this->removeDepend($fandom, 'origins', Origin::class);
            $characters = $this->removeDepend($fandom, 'characters', Character::class);
            $fandom_tags = $this->removeDepend($fandom, 'fandom_tags', Tag::class);

            // удаление пейрингов
            $pairings = $session->get('create.pairings');
            $to_remove = [];
            if ($pairings) {
                foreach ($pairings as $key => $pairing) {
                    $pairing_characters = Character::find()->where(['fandom_id' => $fandom])->andWhere(['in', 'id', $pairing['characters']]);
                    if ($pairing_characters) $to_remove[] = $key;
                }
                foreach ($to_remove as $key) {
                    unset($pairings[$key]);
                }
                $session->set('create.pairings', $pairings);
            }

            return [
                'origins' => $origins,
                'characters' => $characters,
                'fandom_tags' => $fandom_tags,
                'pairings' => $to_remove
            ];
        }
        return [];
    }
    public function removeDepend($fandom, $type, $model) {
        $session = Yii::$app->session;
        $save = [];
        $metas = $session->get('create.' . $type);
        if ($metas) {
            $fandom_metas = $model::find()->where(['fandom_id' => $fandom])->all();
            foreach ($fandom_metas as $fandom_meta) {
                $key = array_search($fandom_meta->id, $metas);
                $save[] = $fandom_meta->id;
                if ($key !== false) unset($metas[$key]);
            }
            $session->set('create.' . $type, $metas);
        }
        return $save;
    }

    public function actionUnsetFandom() {
        $session = Yii::$app->session;
        $session->set('create.fandoms', []);
        $session->set('create.origins', []);
        $session->set('create.characters', []);
        $session->set('create.pairings', []);
        $session->set('create.fandom_tags', []);
    }



    public function actionManagePairing() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $action = Yii::$app->request->post('action');
        $id = Yii::$app->request->post('pairing');
        if ($action == 'create') {
            $pairings = $session->get('create.pairings');
            $relationships = Relationship::find()->all();
            // по умолчанию между персонажами романтическая связь
            $pairings[] = ['relationship' => $relationships[0]->id, 'characters' => []];
            $session->set('create.pairings', $pairings);
            return [
                'id' => array_key_last($pairings),
                'this_relationship' => $relationships[0]->id,
                'relationships' => $relationships
            ];
        }
        return [];
    }


    public function actionFindMeta() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $input = $request->post('input');
        $meta_type = $request->post('meta_type');
        $type_id = $request->post('type');

        $session = Yii::$app->session;

        if ($meta_type == 'genres') return $this->findMeta(Genre::class, $input, $session->get('create.genres'), $type_id);
        if ($meta_type == 'tags') return $this->findMeta(Tag::class, $input, $session->get('create.tags'), $type_id);
        if ($meta_type == 'fandoms') return $this->findMeta(Fandom::class, $input, $session->get('create.fandoms'));

        if ($meta_type == 'origins') {
            $fandom = $request->post('fandom_id');
            $origins = []; $origins_data = [];
            if ($fandom)
                $origins = Fandom::findOne($fandom)->origins;
            if ($origins)
                foreach ($origins as $origin) {
                    $checked = $session->get('create.origins') ? (in_array($origin->id, $session->get('create.origins')) ? 'checked' : '') : '';
                    $origins_data[] = ['origin' => $origin, 'media' => $origin->media->singular_title, 'checked' => $checked];
                }
            return $origins_data;
        }

        if ($meta_type == 'characters') {
            $data = [];
            $characters = Character::find()
                ->andFilterWhere(['like', 'full_name', $input])
                ->andFilterWhere(['not in', 'id', $session->get('create.characters')])
                ->andFilterWhere(['in', 'fandom_id', $session->get('create.fandoms')])
                ->all();
            foreach ($characters as $key => $value) $data[$key] = ['character' => $value, 'fandom' => $value->fandom];
            return $data;
        }

        if ($meta_type == 'pairing_characters') {
            $data = [];
            $pairing_id = $type_id;
            $pairing_characters = $session->get('create.pairings')[$pairing_id]['characters'];
            $characters = Character::find()
                ->andFilterWhere(['like', 'full_name', $input])
                ->andFilterWhere(['not in', 'id', $pairing_characters])
                ->andFilterWhere(['in', 'fandom_id', $session->get('create.fandoms')])
                ->all();
            foreach ($characters as $key => $value) $data[$key] = ['character' => $value, 'fandom' => $value->fandom];

            return $data;
        }

        if ($meta_type == 'fandom_tags') return $this->findMeta(Tag::class, $input, $session->get('create.fandom_tags'), 6);

        if ($meta_type == 'coauthor') return $this->findMeta(User::class, $input, $session->get('create.coauthor'), Yii::$app->user->identity->id);
        if ($meta_type == 'beta') return $this->findMeta(User::class, $input, $session->get('create.beta'), Yii::$app->user->identity->id);
        if ($meta_type == 'gamma') return $this->findMeta(User::class, $input, $session->get('create.gamma'), Yii::$app->user->identity->id);

        return [];
    }
    public function findMeta($model, $input = null, $selected = null, $type = null) {
        $session = Yii::$app->session;
        $data = [];
        $metas = $model::find();

        if ($model != User::class) $metas->filterWhere(['like', 'title', $input]); // подумать потом о безопасности этого всего
        else $metas->filterWhere(['like', 'login', $input]);
        $metas->andFilterwhere(['not in', 'id', $selected]);

        if ($model == Genre::class) if ($type) $metas->andWhere(['type_id' => $type]); // потому что оно 0 считает за значение
        if ($model == Tag::class) {
            if ($type) {
                if ($type != 6) $metas->andFilterWhere(['type_id' => $type])->andWhere(['<>', 'type_id', 6]); // проверка нужна, потому что 0 это все
                if ($type == 6) { // фэндомные теги не должны отображаться
                    $metas->andWhere(['type_id' => $type])->andWhere(['in', 'fandom_id', $session->get('create.fandoms')]);
                }
            }
            else $metas->andWhere(['<>', 'type_id', 6]);
        }

        if ($model == User::class) $metas->andFilterWhere(['is_publisher' => 0])->andWhere(['<>', 'id', $type]);

        $find_metas = $metas->all();
        foreach ($find_metas as $key => $value) $data[$key] = $value;

        return $data;
    }
    public function findAndSortMeta($ids, $model) {
        if (!$ids) return [];
        $creates = $model::findAll(['id' => $ids]);
        if ($creates) {
            $sort = [];
            foreach ($ids as $id)
                foreach ($creates as $create)
                    if ($create->id == $id) {
                        $sort[] = $create;
                        break;
                    }
            return $sort;
        }
        else return [];
    }
}