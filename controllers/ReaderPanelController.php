<?php

namespace app\controllers;

use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use app\models\Like;
use app\models\_BookData;

class ReaderPanelController extends Controller
{
    public function actionLibrary()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = Yii::$app->user->identity->id;
        $likes = Like::find()->where(['user_id' => $user])->all();
        $books = [];

        if ($likes) {
            foreach ($likes as $like) {
                $books[$like->book_id] = new _BookData($like->book_id);
            }
        }

        return $this->render('library', [
            'books' => $books
        ]);
    }

    public function actionCollections()
    {

    }

    public function actionFollowedAuthors()
    {

    }

    public function actionViewHistory()
    {

    }
}