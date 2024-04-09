<?php
$this->title = Yii::$app->name.' – вход';

/* @var $model */

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerCssFile("@web/css/site/login.css");

?>

<div class="center-container">
    <? $f = ActiveForm::begin([
            'method' => 'post',
            'id' => 'form-login',
            'fieldConfig' => [
                'template' => "{input}\n{error}"
            ],
            'options' => ['class' => 'enter-form'],
        ])
    ?>

    <div class="enter-form-header">
        <div class="header1">Вход</div>
        <div class="">Ещё нет аккаунта? <?= Html::a('Зарегистрироваться', Url::to('site/signup'))?></div>
    </div>

    <div class="enter-form-fields">
        <?= $f->field($model, 'login', [
            'options' => ['class' => 'ui field field-with-hint'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}\n{hint}{error}",
        ])->textInput(['autofocus' => false, 'placeholder' => 'Имя пользователя'])->label(false); ?>

        <?=$f->field($model, 'password', [
            'options' => ['class' => 'ui field password-field field-with-hint'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}\n<div class=\"password-toggle-button\"><div class=\"vertical-line\"></div>" . visibility_icon . "</div>\n{hint}{error}",
        ])->passwordInput(['placeholder' => 'Пароль'])->label(false); ?>

        <div class="space-between">

            <?= $f->field($model, 'remember_me', [
                'options' => ['tag' => false],
                'template' => '{input}',
            ])->checkbox([
                'id' => 'remember_me',
                'label' => false,
            ]) ?>
            <label for="remember_me">Запомнить меня</label>

            <a href="">Забыли пароль?</a>
        </div>
    </div>

    <?= Html::submitButton('Войти', ['class' => 'ui button colored-button', 'name' => 'login-submit']) ?>
    <? ActiveForm::end() ?>
</div>
