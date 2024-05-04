<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="header2">Основное</div>

<div class="metadata-item">
    <label for="step-meta-title" class="header3 metadata-item-title">
        <div>Название <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">150</span>
    </label>
    <div class="ui field"><input type="text" name="step-meta-title" id="step-meta-title" placeholder="Название книги"></div>
    <div class="input-error"></div>
</div>

<div class="metadata-item">
    <label for="step-meta-description" class="header3 metadata-item-title">
        <div>Описание <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">800</span>
    </label>
    <div class="ui field"><textarea name="step-meta-description" id="step-meta-description" rows="8" placeholder="Расскажите, о чём эта книга"></textarea></div>
    <div class="input-error"></div>
</div>

