<?php
$this->title = Yii::$app->name.' – регистрация';

/* @var $model*/

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->registerCssFile("@web/css/site/login.css");

?>

<div class="center-container">
    <? $f = ActiveForm::begin([
        'method' => 'post',
        'id' => 'form-signup',
        'fieldConfig' => [
            'template' => "{input}\n{error}",
        ],
        'options' => ['class' => 'enter-form'],
    ]) ?>

    <div class="enter-form-header">
        <div class="header1">Регистрация</div>
        <div class="">Уже есть аккаунт? <?= Html::a('Войти', Url::to(['site/login']), ['class' => 'highlight-link']) ?></div>
    </div>

    <div class="enter-form-fields">
        <div class="record-item">
            <?= $f->field($model, 'login', [
                'options' => ['class' => 'ui field'],
                'inputOptions' => ['class' => ''],
                'template' => "{input}",
            ])->textInput(['placeholder' => 'Имя пользователя', 'maxlength' => '50'])->label(false); ?>
            <?= $f->field($model, 'login', [
                'options' => ['class' => 'under-field'],
                'template' => "{hint}{error}",
            ])->hint('Не менее 6, не более 50 символов.', ['class' => 'hint']); ?>
        </div>

        <div class="record-item">
            <?= $f->field($model, 'email', [
                'options' => ['class' => 'ui field'],
                'inputOptions' => ['class' => ''],
                'template' => "{input}",
            ])->textInput(['placeholder' => 'Электронная почта'])->label(false); ?>
            <?= $f->field($model, 'email', [
                'options' => ['class' => 'under-field'],
                'template' => "{hint}{error}",
            ]); ?>
        </div>

        <div class="record-item">
            <?= $f->field($model, 'password', [
                'options' => ['class' => 'ui field'],
                'inputOptions' => ['class' => ''],
                'template' => "{input}",
                // 'template' => "{input}\n<div class=\"password-toggle-button\"><div class=\"vertical-line\"></div>" . visibility_icon . "</div>\n{hint}{error}",
            ])->passwordInput(['placeholder' => 'Пароль', 'maxlength' => '40'])->label(false); ?>
            <?= $f->field($model, 'password', [
                'options' => ['class' => 'under-field'],
                'template' => "{hint}{error}",
            ])->hint('Не менее 8, не более 40 символов, хотя бы одна цифра и специальный символ.', ['class' => 'hint']); ?>
        </div>

    </div>

    <?= Html::submitButton('Зарегистрироваться', ['class' => 'ui button colored-button', 'name' => 'login-submit']) ?>
    <? ActiveForm::end() ?>
</div>
