<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;

class AuthorPanelController extends Controller
{
    public function actionBookDashboard() {
        if (Yii::$app->user->isGuest) return $this->goHome();

        return $this->render('book_dashboard');
    }

    public function actionBook()
    {
        return $this->render('book');
    }
}