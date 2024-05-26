<?php
/** @var yii\web\View $this */

/* @var $create_public_editing int */
/* @var $public_editing PublicEditing[] */

use app\models\Tables\PublicEditing;

?>

<div class="header2">Общие параметры</div>

<!-- ПУБЛИЧНОЕ РЕДАКТИРОВАНИЕ -->
<div class="metadata-item direct-to-session">
    <div class="header3 metadata-item-title" id="step-meta-public_editing">
        <div>Публичное редактирование <span class="required-symbol">*</span></div>
    </div>
    <div class="input-block-list" id="step-meta-public_editing">
        <? foreach ($public_editing as $editing) {
            $editing_checked = $editing->id == $create_public_editing ? 'checked' : ''; ?>
            <label class="ui choice-input-block">
                <input type="radio" name="rating" value="<?=$editing->id?>" <?=$editing_checked?>>
                <span>
                    <div class="title-description">
                        <?=$editing->title?>
                        <div class="tip"><?=$editing->description?></div>
                    </div>
                </span>
            </label>
        <?}?>
    </div>
    <div class="input-error"></div>
</div>



<div class="header2">Соавтор</div>
<div class="head-article">На данный момент вы можете добавить только одного соавтора</div>

<!-- СОАВТОР -->
<div class="metadata-item chosen-items-to-session coauthor-item">
    <div class="field-with-dropdown">
        <div class="ui field"><input type="text" name="step-meta-coauthor" id="step-meta-coauthor" placeholder="Введите первые несколько символов" maxlength="150"></div>
    </div>
    <div class="metadata-item-selected metadata-fandom-selected hidden"></div>
    <div class="input-error"></div>
</div>


<div class="header2">Редакторы</div>
<div class="head-article">На данный момент вы можете добавить одну бету и одну гамму</div>

<!-- БЕТА -->
<div class="metadata-item chosen-items-to-session coauthor-item">
    <div class="header3 metadata-item-title" id="step-meta-beta">Бета</div>
    <div class="field-with-dropdown">
        <div class="ui field"><input type="text" name="step-meta-beta" id="step-meta-beta" placeholder="Введите первые несколько символов" maxlength="150"></div>
    </div>
    <div class="metadata-item-selected metadata-fandom-selected hidden"></div>
    <div class="input-error"></div>
</div>

<!-- ГАММА -->
<div class="metadata-item chosen-items-to-session coauthor-item">
    <div class="header3 metadata-item-title" id="step-meta-gamma">Гамма</div>
    <div class="field-with-dropdown">
        <div class="ui field"><input type="text" name="step-meta-gamma" id="step-meta-gamma" placeholder="Введите первые несколько символов" maxlength="150"></div>
    </div>
    <div class="metadata-item-selected metadata-fandom-selected hidden"></div>
    <div class="input-error"></div>
</div>