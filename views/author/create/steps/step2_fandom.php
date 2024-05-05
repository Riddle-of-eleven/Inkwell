<?php
/** @var yii\web\View $this */

/* @var Type[] $book_types */

use app\models\Tables\Type;

?>

<div class="header2">Тип книги</div>
<div class="head-article">
    Если ваша книга является фанфиком, у вас появится возможность указать фэндом, первоисточники, персонажей и пейринги.
</div>
<div class="metadata-item">
    <div class="input-block-list">
        <? foreach ($book_types as $book_type) {?>
            <div class='ui choice-input-block'>
                <input type='radio' name='book_type' id="book_type-<?=$book_type->id?>" value='<?=$book_type->id?>'>
                <label for='book_type-<?=$book_type->id?>'><?=$book_type->title?></label>
            </div>
        <?}?>
    </div>
    <div class="input-error"></div>
</div>


<div class="header2">Фэндомные сведения</div>
<!-- ФЭНДОМ -->
<div class="metadata-item">
    <label for="step-meta-fandom" class="header3 metadata-item-title">
        <div>Фэндом и первоисточники <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">5</span>
    </label>
    <div class="ui field"><input type="text" name="step-meta-fandom" id="step-meta-fandom" placeholder="Введите первые несколько символов" maxlength="150"></div>
    <div class="fandom-metadata-item-selected hidden"></div>
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

