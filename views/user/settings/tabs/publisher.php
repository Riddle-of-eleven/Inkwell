<?php
/** @var View $this */
/* @var FormPublisherSettings $publisher_model*/

use app\models\Forms\User\FormPublisherSettings;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="header2">Официальная информация</div>
<? $publisher = ActiveForm::begin([
    'method' => 'post',
    'id' => 'publisher-data-form',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => '']
]) ?>

<!-- ОФИЦИАЛЬНЫЙ САЙТ -->
<div class="record-item">
    <div class="header3">Адрес официального сайта</div>
    <div class="field-item">
        <?= $publisher->field($publisher_model, 'official_website', [
            'options' => ['class' => 'ui field'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}",
        ])->textInput(['placeholder' => 'Вы можете указать официальный сайт', 'maxlength' => '200'])->label(false); ?>
        <?= $publisher->field($publisher_model, 'official_website', [
            'options' => ['class' => 'under-field'],
            'template' => "{error}",
        ]) ?>
    </div>
</div>

<?= Html::submitButton(save_icon . 'Сохранить изменения', ['class' => 'ui button icon-button', 'name' => 'public-data-submit']) ?>
<? ActiveForm::end() ?>