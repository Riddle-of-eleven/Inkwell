<?php

namespace app\controllers\author;

use app\models\Tables\Fandom;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DeleteController extends Controller
{
    public function actionDeleteFandom() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->request->post('fandom_id');
            $user = Yii::$app->user->identity->id;
            $fandom = Fandom::findOne($id);

            if ($fandom->this_creator_id == $user) {
                if ($fandom->delete()) return ['success' => true, 'exists' => false];
                else return ['success' => true, 'exists' => true];
            }
            else return ['success' => false];
        }
        return ['success' => false];
    }
}