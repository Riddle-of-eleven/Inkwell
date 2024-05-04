<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="header2">Основное</div>

<!-- НАЗВАНИЕ -->
<div class="metadata-item">
    <label for="step-meta-title" class="header3 metadata-item-title">
        <div>Название <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">150</span>
    </label>
    <div class="ui field"><input type="text" name="step-meta-title" id="step-meta-title" placeholder="Название книги" maxlength="150"></div>
    <div class="input-error"></div>
</div>

<!-- ОПИСАНИЕ -->
<div class="metadata-item">
    <label for="step-meta-description" class="header3 metadata-item-title">
        <div>Описание <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">800</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-description" id="step-meta-description" rows="6" placeholder="Расскажите, о чём эта книга" maxlength="800"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ПРИМЕЧАНИЯ -->
<div class="metadata-item">
    <label for="step-meta-remark" class="header3 metadata-item-title">
        <div>Примечания</div>
        <span class="content-limit tip-color">2000</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-remark" id="step-meta-remark" rows="8" placeholder="Здесь вы можете написать что-нибудь интересное" maxlength="800"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ДИСКЛЕЙМЕР -->
<div class="metadata-item">
    <label for="step-meta-disclaimer" class="header3 metadata-item-title">
        <div>Дисклеймер</div>
        <span class="content-limit tip-color">500</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-disclaimer" id="step-meta-disclaimer" rows="4" placeholder="Если в книге содержатся моменты, о которых вы хотите предупредить читателей, впишите это сюда" maxlength="800"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ПОСВЯЩЕНИЕ -->
<div class="metadata-item">
    <label for="step-meta-dedication" class="header3 metadata-item-title">
        <div>Посвящение</div>
        <span class="content-limit tip-color">500</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-dedication" id="step-meta-dedication" rows="4" placeholder="Если книга посвящена кому-либо или чему-либо, напишите об этом здесь" maxlength="800"></textarea>
    </div>
    <div class="input-error"></div>
</div>