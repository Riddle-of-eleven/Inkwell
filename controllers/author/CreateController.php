<?php

namespace app\controllers\author;

use app\models\Tables\Fandom;
use app\models\Tables\Genre;
use app\models\Tables\GenreType;
use app\models\Tables\Origin;
use app\models\Tables\Rating;
use app\models\Tables\Relation;
use app\models\Tables\Size;
use app\models\Tables\Tag;
use app\models\Tables\TagType;
use app\models\Tables\Type;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class CreateController extends Controller
{
    public function actionNewBook() {
        $session = Yii::$app->session;
        $step = $session->has('step') ? $session->get('step') : 'main';
        $session['create.aaa'] = 'aaa';

        return $this->render('new-book', [
            'step' => $step,
        ]);
    }


    // вспомогательные функции
    public function actionLoadStepMain() {
        $session = Yii::$app->session;

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
        $tag_types = TagType::find()->all();


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

        // субъективные данные
        $create_book_type = $session->get('create.book_type');
        $sort_fandoms = $this->findAndSortMeta($session->get('create.fandoms'), Fandom::class);
        $create_origins = $session->get('create.origins');

        //объективные данные
        $book_types = Type::find()->all();

        return $this->renderAjax('steps/step2_fandom', [
            // субъективные
            'create_book_type' => $create_book_type,
            'create_fandoms' => $sort_fandoms,
            'create_origins' => $create_origins,
            // объективные
            'book_types' => $book_types,
        ]);
    }
    public function actionLoadStepCover() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderAjax('steps/step3_cover');
    }
    public function actionLoadStepAccess() {
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderAjax('steps/step4_access');
    }


    public function actionRememberStep() {
        $session = Yii::$app->session;
        $session->set('step', Yii::$app->request->post('step'));
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
        else
            $session->set('create.' . $session_key, $data);

    }
    public function actionRemoveOrigins() {
        $session = Yii::$app->session;
        $fandom = Yii::$app->request->post('fandom_id');
        if ($fandom) {
            $origins = $session->get('create.origins');
            $fandom_origins = Origin::find()->where(['fandom_id' => $origins])->all();
            foreach ($fandom_origins as $fandom_origin) {
                $key = array_search($fandom_origin->id, $origins);
                if ($key !== false) unset($origins[$key]);
            }
            $session->set('create.origins', $origins);
        }
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
                    $checked = in_array($origin->id, $session->get('create.origins')) ? 'checked' : '';
                    $origins_data[] = ['origin' => $origin, 'media' => $origin->media->singular_title, 'checked' => $checked];
                }
            return $origins_data;
        }
        //if ($meta_type == 'genre') return $this->findMeta(Genre::class, $input);
        return [];
    }
    public function findMeta($model, $input = null, $selected = null, $type = null) {
        $data = [];
        $metas = $model::find();

        $metas->filterWhere(['like', 'title', $input]); // подумать потом о безопасности этого всего
        $metas->andFilterwhere(['not in', 'id', $selected]);
        if ($type) $metas->andWhere(['type_id' => $type]); // проверка нужна, потому что 0 это все

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