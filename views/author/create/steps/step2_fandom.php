<?php
/** @var yii\web\View $this */

/* @var Type[] $book_types */

use app\models\Tables\Type;

?>

<div class="header2">Тип книги</div>
<div class="head-article tip-color">Если ваша книга является фанфиком, у вас появится возможность указать фэндом, первоисточники, персонажей и пейринги.</div>
<div class="metadata-item">
    <div class="input-block-list">
        <? foreach ($book_types as $book_type) {?>
            <label class="ui choice-input-block">
                <input type='radio' name='book_type' id="book_type-<?=$book_type->id?>" value='<?=$book_type->id?>'>
                <span><?=$book_type->title?></span>
            </label>
        <?}?>
    </div>
    <div class="input-error"></div>
</div>


<div class="header2">Фэндомные сведения</div>
<div class="head-article tip-color">Для каждого фэндома можно указать сколько угодно первоисточником</div>
<!-- ФЭНДОМ -->
<div class="metadata-item">
    <label for="step-meta-fandom" class="header3 metadata-item-title">
        <div>Фэндом и первоисточники <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">5</span>
    </label>
    <div class="ui field"><input type="text" name="step-meta-fandom" id="step-meta-fandom" placeholder="Введите первые несколько символов" maxlength="150"></div>
    <div class="fandom-metadata-item-selected ">
        <details open>
            <summary class="block select-header">
                <div class="select-header-expand"><div class="expand-icon"><?=expand_more_icon?></div>Название</div>
                <div class="ui button small-button danger-accent-button remove-fandom" fandom="${fandom}"><?=delete_icon?></div>
            </summary>
            <div class="inner-details-field">
                <div class="inner-details-choice self-table">
                    <div></div>
                    <div>Название</div>
                    <div>Тип медиа</div>
                    <div>Год создания</div>
                    <div>Создатель</div>
                </div>
                <label class="inner-details-choice">
                    <input type='checkbox' name='book_type' id="" value=''>
                    <span><div>dhdhdh</div><div>fdhfhd</div><div>dfhfdh</div><div>dhdfh</div></span>
                </label>
            </div>
        </details>
    </div>
    <div class="input-error"></div>
</div>

<!-- ПЕРСОНАЖИ -->
<div class="metadata-item">
    <label for="step-meta-characters" class="header3 metadata-item-title">
        <div>Персонажи</div>
        <span class="content-limit tip-color">20</span>
    </label>
    <div class="metadata-item-selected hidden"></div>
    <div class="ui field"><input type="text" name="step-meta-characters" id="step-meta-characters" placeholder="Введите первые несколько символов" maxlength="150"></div>
    <div class="input-error"></div>
</div>

<!-- ПЕЙРИНГИ -->
<div class="metadata-item">
    <label for="step-meta-pairing" class="header3 metadata-item-title">
        <div>Пейринги</div>
        <span class="content-limit tip-color">5</span>
    </label>
    <div class="metadata-item-selected hidden"></div>
    <div class="ui field"><input type="text" name="step-meta-pairing" id="step-meta-pairing" placeholder="Введите первые несколько символов" maxlength="150"></div>
    <div class="input-error"></div>
</div>

