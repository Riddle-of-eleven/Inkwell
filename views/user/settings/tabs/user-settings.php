<?php
/** @var View $this */

/* @var FormSystemSettings $system_model */
/* @var FormPublicSettings $public_model */


use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\Forms\User\FormSystemSettings;
use app\models\Forms\User\FormPublicSettings;

$user = Yii::$app->user->identity;
$preview_hidden = $user->avatar ? '' : 'hidden';
$avatar = $user->avatar ? Html::img('@web/images/avatar/uploads/' . $user->avatar . '.png') : '';

?>

<div class="header2">Системные данные</div>
<? $system = ActiveForm::begin([
    'method' => 'post',
    'id' => 'system-data-form',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute('validate-password'),
]) ?>


<!-- ИМЯ ПОЛЬЗОВАТЕЛЯ -->
<div class="record-item">
    <div class="header3">Имя пользователя</div>
    <div class="field-item">
        <?= $system->field($system_model, 'login', [
            'options' => ['class' => 'ui field'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}",
        ])->textInput(['placeholder' => 'Имя пользователя', 'maxlength' => '50'])->label(false); ?>
        <?= $system->field($system_model, 'login', [
            'options' => ['class' => 'under-field'],
            'template' => "{hint}{error}",
        ])->hint('Не менее 6, не более 50 символов', ['class' => 'hint']); ?>
    </div>
</div>


<!-- ЭЛЕКТРОННАЯ ПОЧТА -->
<div class="record-item">
    <div class="header3">Электронная почта</div>
    <?= $system->field($system_model, 'email', [
        'options' => ['class' => 'ui field field-with-hint'],
        'inputOptions' => ['class' => ''],
        'template' => "{input}",
    ])->textInput(['placeholder' => 'Адрес электронной почты'])->label(false); ?>
    <?= $system->field($system_model, 'email', [
        'options' => ['class' => 'under-field'],
        'template' => "{error}",
    ])?>
</div>

<div class="record-item">
    <div class="header3">Пароль</div>
    <div class="head-article">Для смены пароля необходимо знать ваш текущий пароль. <?=Html::a('Забыли пароль?', Url::to(['']), ['class' => 'highlight-link'])?></div>

    <!-- СТАРЫЙ ПАРОЛЬ -->
    <div class="field-item">
        <?= $system->field($system_model, 'old_password', [
            'options' => ['class' => 'ui field'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}",
        ])->passwordInput(['placeholder' => 'Старый пароль'])->label(false); ?>
        <?= $system->field($system_model, 'old_password', [
            'options' => ['class' => 'under-field'],
            'template' => "{error}",
        ])?>
    </div>
    <!-- НОВЫЙ ПАРОЛЬ -->
    <div class="field-item">
        <?= $system->field($system_model, 'new_password', [
            'options' => ['class' => 'ui field'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}",
        ])->passwordInput(['placeholder' => 'Новый пароль'])->label(false); ?>
        <?= $system->field($system_model, 'new_password', [
            'options' => ['class' => 'under-field'],
            'template' => "{hint}{error}",
        ])->hint('Не менее 8 и не более 40 символов, хотя бы одна цифра и специальный символ', ['class' => 'hint']); ?>
    </div>
</div>

<?= Html::submitButton(save_icon . 'Сохранить изменения', ['class' => 'ui button icon-button', 'name' => 'system-data-submit']) ?>
<? ActiveForm::end() ?>


<div class="header2">Публичные сведения</div>

<? $public = ActiveForm::begin([
    'method' => 'post',
    'id' => 'public-data-form',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
    /*'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute('validate-password'),*/
]) ?>

<!-- О СЕБЕ -->
<div class="record-item">
    <div class="header3">О себе</div>
    <div class="field-item">
        <?= $public->field($public_model, 'about', [
            'options' => ['class' => 'ui field'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}",
        ])->textarea(['placeholder' => 'Впишите сюда описание профиля', 'maxlength' => '800', 'rows' => '8'])->label(false); ?>
        <?= $public->field($public_model, 'about', [
            'options' => ['class' => 'under-field'],
            'template' => "{error}",
        ]) ?>
    </div>
</div>

<!-- КОНТАКТНАЯ ИНФОРМАЦИЯ -->
<div class="record-item">
    <div class="header3">Контактная информация</div>
    <div class="field-item">
        <?= $public->field($public_model, 'contact', [
            'options' => ['class' => 'ui field'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}",
        ])->textarea(['placeholder' => 'Расскажите о том, как с вами можно связаться', 'maxlength' => '500', 'rows' => '6'])->label(false); ?>
        <?= $public->field($public_model, 'contact', [
            'options' => ['class' => 'under-field'],
            'template' => "{error}",
        ]) ?>
    </div>
</div>

<?= Html::submitButton(save_icon . 'Сохранить изменения', ['class' => 'ui button icon-button', 'name' => 'public-data-submit']) ?>
<? ActiveForm::end() ?>



<div class="header2">Аватар</div>

<div class="record-item">
    <div class="header3 metadata-item-title" id="step-meta-rating">Выбор файла</div>
    <div class="">
        <label class="upload-container">
            <span class="upload-text highlight">Перетащите файл сюда</span>
            <span class="upload-text">или</span>
            <input type="file" name="user-avatar" id="user-avatar"">
            <span class="ui button icon-button"><?=backup_icon?>Загрузите его с устройства</span>
        </label>
    </div>
    <div class="input-error"></div>

    <div class="avatar-preview <?=$preview_hidden?>">
        <div class="header3 metadata-item-title">Предпросмотр аватара</div>
        <div id="image-preview" class="avatar-image-preview"><?=$avatar?></div>
        <div class="avatar-buttons">
            <div class="ui button icon-button danger-accent-button" id="button-restore"><?=hide_image_icon?>Удалить аватар</div>
            <div class="ui button icon-button hidden" id="button-crop"><?=imagesmode_icon?>Сохранить результат</div>
        </div>
    </div>
</div>


<!--<dialog class="block modal">
    <div class="close-button" id="close-delete-avatar"><?=close_icon?></div>
    <div class="modal-container" id="regular-modal">
        <div class="header3">Вы точно хотите удалить аватар?</div>
        <div>Он будет удалён без возможности восстановления</div>
    </div>
    <div class="modal-choice">
        <div class="ui button danger-accent-button">Удалить аватар</div>
        <div class="ui button">Оставить</div>
    </div>
</dialog>-->