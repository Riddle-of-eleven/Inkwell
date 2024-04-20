<?php

namespace app\controllers\author;

use Yii;
use yii\web\Controller;

class CreateBookController extends Controller
{
    public function actionCreateMain()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('create-main');
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