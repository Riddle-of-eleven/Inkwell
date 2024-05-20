<?php

namespace app\controllers\user;

use Yii;
use yii\web\Controller;
use app\models\Tables\User;
use app\models\Forms\User\FormSystemSettings;
use app\models\Forms\User\FormPublicSettings;

use yii\helpers\VarDumper;

class SettingsController extends Controller
{
    public function actionShow() {
        $session = Yii::$app->session;
        $tab = $session->has('settings.show.tab') ? $session->get('settings.show.tab') : 'user-settings';
        $user = User::findOne(Yii::$app->user->identity->id);

        return $this->render('settings', [
            'tab' => $tab,
            'user' => $user
        ]);
    }

    public function actionLoadUserSettings() {
        $session = Yii::$app->session;
        $session->set('settings.show.tab', 'user-settings');

        $system_model = new FormSystemSettings();
        $user = Yii::$app->user->identity;
        $system_model->login = $user->login;
        $system_model->email = $user->email;

        $public_model = new FormPublicSettings();

        return $this->renderAjax('tabs/user-settings', [
            'system_model' => $system_model,
            'public_model' => $public_model,
        ]);
    }

    public function actionLoadBlacklist() {
        $session = Yii::$app->session;
        $session->set('settings.show.tab', 'blacklist');
        return $this->renderAjax('tabs/blacklist');
    }
    public function actionLoadPublisher() {
        $session = Yii::$app->session;
        $session->set('settings.show.tab', 'publisher');
        return $this->renderAjax('tabs/publisher');
    }
    public function actionLoadActions() {
        $session = Yii::$app->session;
        $session->set('settings.show.tab', 'actions');
        return $this->renderAjax('tabs/actions');
    }
}