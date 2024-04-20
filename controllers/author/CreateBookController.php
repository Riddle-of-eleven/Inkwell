<?php

namespace app\controllers\author;

use app\models\CreateBookForms\FormCreateMain;
use app\models\Genre;
use app\models\Rating;
use app\models\Relation;
use app\models\Size;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;

class CreateBookController extends Controller
{
    public function actionFindGenres() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $input = Yii::$app->request->post('input');
        // экранировать потом это дело
        if ($input) {
            $genres = Genre::find()->where(['like', 'title', $input])->all();
            foreach ($genres as $genre) {
                $data[$genre->id] = $genre->title;
            }
        }
        else {
            $genres = Genre::getGenresList();
            foreach ($genres as $key => $genre) {
                $data[$key] = $genre;
            }
        }

        return $data;
    }

    public function actionCreateMain()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();

        $model = new FormCreateMain();
        $relations = Relation::getRelationsList();
        $ratings = Rating::getRatingsList();
        $plan_sizes = Size::getSizesList();
        $genres = Genre::getGenresList();

        /*if (Yii::$app->request->post()) {
            VarDumper::dump(Yii::$app->request->post(), 10, true);
            die;
        }*/

        return $this->render('create-main', [
            'model'=> $model,
            'relations' => $relations,
            'ratings' => $ratings,
            'plan_sizes' => $plan_sizes,
            'genres' => $genres,
        ]);
    }

    public function actionCreateFandom()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('create-fandom');
    }

    public function actionCreateCover()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('create-cover');
    }

    public function actionCreateAccess()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('create-access');
    }
}