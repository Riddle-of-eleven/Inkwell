<?php

namespace app\controllers\user;

use yii\web\Controller;

class NotificationsController extends Controller
{
    public function actionAll() {
        return $this->render('all');
    }
}