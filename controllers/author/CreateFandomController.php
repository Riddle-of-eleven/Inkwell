<?php

namespace app\controllers\author;

use app\models\CreateFandomForms\FormCreateFandom;
use app\models\Tables\Fandom;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;

class CreateFandomController extends Controller
{
    public function actionCreateFandom() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $model = new FormCreateFandom();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $fandom = new Fandom();
            $fandom->title = $model->title;
            $fandom->description = $model->description;
            $fandom->created_at = new Expression('NOW()');
            $fandom->this_creator_id = Yii::$app->user->identity->id;

            if ($fandom->save()) return $this->redirect(Url::to(['author/author-panel/fandoms-dashboard']));
        }

        return $this->render('create-fandom', [
            'model' => $model,
        ]);
    }
}