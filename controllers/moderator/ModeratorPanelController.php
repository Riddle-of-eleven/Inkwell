<?php

namespace app\controllers\moderator;

use app\models\Forms\Moderator\FormChooseType;
use app\models\Forms\Moderator\FormCreateTag;
use app\models\Tables\Genre;
use app\models\Tables\GenreType;
use app\models\Tables\Tag;
use app\models\Tables\TagType;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;

class ModeratorPanelController extends Controller
{
    public function actionTagsDashboard() {
        if (!Yii::$app->user->getIdentity()->is_moderator == 1) return $this->goHome();
        $id = Yii::$app->user->identity->id;
        $tags = Tag::find()->where(['moderator_id' => $id])->all();
        $genres = Genre::find()->where(['moderator_id' => $id])->all();

        return $this->render('tags-dashboard', [
            'genres' => $genres,
            'tags' => $tags,
        ]);
    }

    public function actionChooseType() {
        if (!Yii::$app->user->getIdentity()->is_moderator == 1) return $this->goHome();
        $model = new FormChooseType();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(Url::to(['create', 'type' => $model->type]));
        }

        return $this->render('create-tag/choose-type', [
            'model' => $model,
        ]);
    }

    public function actionCreate() {
        if (!Yii::$app->user->getIdentity()->is_moderator == 1) return $this->goHome();
        $type = (int)Yii::$app->request->get('type');
        if ($type != 1 && $type != 2) return $this->redirect(Url::to('@web/index.php')); // сюда потом вставить страницу какой-нибудь ошибки или что-то такое
        if ($type == 1) {
            $type_name = 'жанр';
            $types = GenreType::getGenreTypesList();
        }
        elseif ($type == 2) {
            $type_name = 'тег';
            $types = TagType::getTagTypesList();
        }

        $model = new FormCreateTag();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //VarDumper::dump($model, 10, true);
            if ($type == 1) {
                $genre = new Genre();
                $genre->title = $model->title;
                $genre ->description = $model->description;
                $genre->created_at = new Expression('NOW()');
                $genre->genre_type_id = $model->type;
                $genre->moderator_id = Yii::$app->user->identity->id;
                if ($genre->save()) return $this->redirect(Url::to(['tags-dashboard']));
            }
            else if ($type == 2) {
                $tag = new Tag();
                $tag->title = $model->title;
                $tag ->description = $model->description;
                $tag->created_at = new Expression('NOW()');
                $tag->tag_type_id = $model->type;
                $tag->moderator_id = Yii::$app->user->identity->id;
                if ($tag->save()) return $this->redirect(Url::to(['tags-dashboard']));
            }
        }

        return $this->render('create-tag/create', [
            'model' => $model,
            'type' => $type,
            'type_name' => $type_name,
            'types' => $types,
        ]);
    }
}