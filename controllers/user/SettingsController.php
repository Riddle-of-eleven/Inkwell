<?php

namespace app\controllers\user;

use app\models\Forms\User\FormPublisherSettings;
use Yii;
use yii\web\Controller;
use app\models\Tables\User;
use app\models\Forms\User\FormSystemSettings;
use app\models\Forms\User\FormPublicSettings;
use yii\helpers\Url;

use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

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
        $security = Yii::$app->security;

        // системные данные
        $system_model = new FormSystemSettings();
        $user = Yii::$app->user->identity;
        $system_model->login = $user->login;
        $system_model->email = $user->email;
        if ($system_model->load(Yii::$app->request->post()) && $system_model->validate()) {
            $change = false;
            if ($user->login != $system_model->login) {
                $user->login = $system_model->login;
                $change = true;
            }
            if ($user->email != $system_model->email) {
                $user->email = $system_model->email;
                $change = true;
            }
            if ($security->validatePassword($system_model->old_password . $user->salt, $user->password)) {
                $salt = $security->generateRandomString();
                $user->password = $security->generatePasswordHash($system_model->new_password . $salt);
                $user->salt = $salt;
                $change = true;
            }

            if ($change) $user->save();
            return $this->redirect(Url::to(['user/settings/show']));
        }

        $public_model = new FormPublicSettings();
        $public_model->about = $user->about;
        $public_model->contact = $user->contact;
        if ($public_model->load(Yii::$app->request->post()) && $public_model->validate()) {
            $change = false;
            if ($user->about != $public_model->about) {
                $user->about = $public_model->about;
                $change = true;
            }
            if ($user->contact != $public_model->contact) {
                $user->contact = $public_model->contact;
                $change = true;
            }

            if ($change) $user->save();
            return $this->redirect(Url::to(['user/settings/show']));
        }


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

        $publisher_model = new FormPublisherSettings();
        $user = Yii::$app->user->identity;
        $publisher_model->official_website = $user->official_website;
        if ($publisher_model->load(Yii::$app->request->post()) && $publisher_model->validate()) {
            $change = false;
            if ($user->official_website != $publisher_model->official_website) {
                $user->official_website = $publisher_model->official_website;
                $change = true;
            }
            if ($change) $user->save();
            return $this->redirect(Url::to(['user/settings/show']));
        }

        return $this->renderAjax('tabs/publisher', [
            'publisher_model' => $publisher_model
        ]);
    }
    public function actionLoadActions() {
        $session = Yii::$app->session;
        $session->set('settings.show.tab', 'actions');
        return $this->renderAjax('tabs/actions');
    }


    public function actionValidatePassword() {
        $system = new FormSystemSettings();
        if (Yii::$app->request->isAjax && $system->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($system);
        }
    }

    public function actionDeleteAvatar() {
        $user = Yii::$app->user->identity;
        $avatar = $user->avatar;
        if (file_exists('images/avatar/uploads/' . $avatar . '.png')) unlink('images/avatar/uploads/' . $avatar . '.png'); // удаляет файл с сервера, если таковой существует
        $user->avatar = null;
        $user->save();
        return $this->redirect(Url::to(['user/settings/show']));
    }
    public function actionSetAvatar() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = Yii::$app->user->identity;
        $image = UploadedFile::getInstanceByName('cropped_image');
        if ($image) {
            $avatar = uniqid();
            $path = 'images/avatar/uploads/' . $avatar . '.png';
            $image->saveAs($path);
            $user->avatar = $avatar;
            $user->save();
        }
        return $this->redirect(Url::to(['user/settings/show']));
    }
}