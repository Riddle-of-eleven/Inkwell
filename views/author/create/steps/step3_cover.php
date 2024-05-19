<?php
/** @var yii\web\View $this */

/* @var $create_cover */

use yii\web\View;
use yii\helpers\VarDumper;
use yii\helpers\Html;

$this->registerCssFile('@web/css/dashboards/cropper.css');
$this->registerJsFile('@web/js/author/create/cropper.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$preview_hidden = $create_cover ? '' : 'hidden';
$crop_hidden = $create_cover ? 'hidden' : '';

?>

<div class="header2">Создание обложки</div>

<div class="metadata-item">
    <div class="head-article" style="margin-bottom: 20px">Вам необязательно выбирать обложку, но если хотите, можете сделать это здесь</div>
    <div class="header3 metadata-item-title" id="step-meta-rating">Выбор файла</div>
    <div class="">
        <label class="upload-container">
            <span class="upload-text highlight">Перетащите файл сюда</span>
            <span class="upload-text">или</span>
            <input type="file" name="step-meta-cover" id="step-meta-cover">
            <span class="ui button icon-button"><?=backup_icon?>Загрузите его с устройства</span>
        </label>
    </div>
    <div class="input-error"></div>

    <div class="cover-preview <?=$preview_hidden?>">
        <div class="header3 metadata-item-title">Предпросмотр обложки</div>
        <div id="image-preview">
            <? if($create_cover) echo Html::img('@web/' . $create_cover, ['class' => 'crop-result block']); ?>
        </div>
        <div class="cover-buttons">
            <div class="ui button icon-button danger-accent-button" id="button-restore"><?=hide_image_icon?>Удалить обложку</div>
            <div class="ui button icon-button <?=$crop_hidden?>" id="button-crop"><?=imagesmode_icon?>Сохранить результат</div>
        </div>
    </div>
</div>