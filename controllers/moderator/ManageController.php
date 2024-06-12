<?php

namespace app\controllers\moderator;

use Yii;
use app\models\Tables\User;
use yii\data\Pagination;
use yii\i18n\Formatter;
use yii\web\Controller;
use yii\web\Response;

class ManageController extends Controller
{
    public function actionBlock() {
        $query = User::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $users = $query->offset($pages->offset)->limit($pages->limit)->all();
        $moderator = Yii::$app->user->identity;
        if ($moderator->is_moderator != 1) return $this->goHome();

        return $this->render('block', [
            'moderator' => $moderator,
            'users' => $users,
            'pages' => $pages
        ]);
    }

    public function actionManageBlock() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->is_moderator == 1) {
                $id = Yii::$app->request->post('id');
                if ($id) {
                    $user = User::findOne($id);
                    if ($user->is_banned == 0) {
                        $user->is_banned = 1;
                        $user->banned_until = date('Y-m-d H:i:s', strtotime("+3 days"));
                        $user->ban_moderator_id = Yii::$app->user->identity->id;
                    }
                    else {
                        $user->is_banned = 0;
                        $user->banned_until = null;
                        $user->ban_moderator_id = null;
                        $user->ban_reason_id = null;
                    }

                    $formatter = new Formatter();
                    if ($user->save()) return ['success' => true, 'is_banned' => $user->is_banned == 1, 'banned_until' => $formatter->asDatetime($user->banned_until, "d MMMM yyyy, HH:mm")];
                    else return ['success' => false, 'is_banned' => $user->is_banned == 1, 'banned_until' => $formatter->asDatetime($user->banned_until, "d MMMM yyyy, HH:mm")];
                }
            }
            else return ['success' => false, 'is_banned' => false];
        }
        else return ['success' => false, 'is_banned' => false];
    }
}