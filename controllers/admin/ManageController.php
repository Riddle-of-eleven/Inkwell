<?php

namespace app\controllers\admin;

use Yii;
use app\models\Tables\User;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\Response;

class ManageController extends Controller
{
    public function actionModerators() {
        $query = User::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $users = $query->offset($pages->offset)->limit($pages->limit)->all();
        $admin = Yii::$app->user->identity;
        if ($admin->is_admin != 1) return $this->goHome();

        return $this->render('moderators', [
            'admin' => $admin,
            'users' => $users,
            'pages' => $pages
        ]);
    }
    public function actionPublishers() {
        $query = User::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $users = $query->offset($pages->offset)->limit($pages->limit)->all();
        $admin = Yii::$app->user->identity;
        if ($admin->is_admin != 1) return $this->goHome();

        return $this->render('publishers', [
            'admin' => $admin,
            'users' => $users,
            'pages' => $pages
        ]);
    }

    public function actionManageModerator() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->is_admin == 1) {
                $id = Yii::$app->request->post('id');
                if ($id) {
                    $user = User::findOne($id);
                    if ($user->is_moderator == 0) $user->is_moderator = 1;
                    else $user->is_moderator = 0;
                    if ($user->save()) return ['success' => true, 'is_moderator' => $user->is_moderator == 1];
                    else return ['success' => false, 'is_moderator' => $user->is_moderator == 1];
                }
            }
            else return ['success' => false, 'is_moderator' => false];
        }
        else return ['success' => false, 'is_moderator' => false];
    }

    public function actionManagePublisher() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->is_admin == 1) {
                $id = Yii::$app->request->post('id');
                if ($id) {
                    $user = User::findOne($id);
                    if ($user->is_publisher == 0) $user->is_publisher = 1;
                    else $user->is_publisher = 0;
                    if ($user->save()) return ['success' => true, 'is_publisher' => $user->is_publisher == 1];
                    else return ['success' => false, 'is_publisher' => $user->is_publisher == 1];
                }
            }
            else return ['success' => false, 'is_publisher' => false];
        }
        else return ['success' => false, 'is_publisher' => false];
    }
}