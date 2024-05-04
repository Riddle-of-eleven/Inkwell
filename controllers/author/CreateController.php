<?php

namespace app\controllers\author;

use Yii;
use yii\web\Controller;

class CreateController extends Controller
{
    public function actionNewBook() {
        return $this->render('new-book');
    }




    // вспомогательные функции
    public function actionLoadStep() {
        $step = Yii::$app->request->post('step');
        /*$session = Yii::$app->session;
        $session->set('step', $step);*/
        return $this->renderPartial('steps/step' . $step);
    }
}