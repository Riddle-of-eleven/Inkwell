<?php
/** @var View $this */

/* @var $create_title */
/* @var $create_description */
/* @var $create_remark */
/* @var $create_disclaimer */
/* @var $create_dedication */

/* @var $create_relation */
/* @var $create_rating */
/* @var $create_plan_size */

/* @var $create_genres */
/* @var $create_tags */


/* @var Relation[] $relations */
/* @var Rating[] $ratings */
/* @var Size[] $plan_sizes */
/* @var GenreType[] $genre_types */
/* @var TagType[] $tag_types */

use yii\web\View;
use app\models\Tables\Relation;
use app\models\Tables\Rating;
use app\models\Tables\Size;
use app\models\Tables\GenreType;
use app\models\Tables\TagType;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;

$this->registerJs(<<<js
    $(title).val(`$create_title`);
    $(description).val(`$create_description`);
    $(remark).val(`$create_remark`);
    $(disclaimer).val(`$create_disclaimer`);
    $(dedication).val(`$create_dedication`);

    countSymbolsFromField($(title), title_length);
    countSymbolsFromField($(description), description_length);
    countSymbolsFromField($(remark), remark_length);
    countSymbolsFromField($(disclaimer), other_length);
    countSymbolsFromField($(dedication), other_length);
    
    countSelectedChildren($(genres), '.metadata-item-selected', length10);
    countSelectedChildren($(tags), '.metadata-item-selected', length20);
js, View::POS_END);

$create_genres_hidden = $create_genres ? '' : 'hidden';
$create_tags_hidden = $create_tags ? '' : 'hidden';

?>

<div class="header2">Основное</div>


<!-- НАЗВАНИЕ -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-title" class="header3 metadata-item-title">
        <div>Название <span class="required-symbol">*</span></div>
        <span class="content-limit tip-color">150</span>
    </label>
    <div class="ui field"><input type="text" name="step-meta-title" id="step-meta-title" placeholder="Название книги" maxlength="150"></div>
    <div class="input-error"></div>
</div>

<!-- ОПИСАНИЕ -->
<div class="metadata-item direct-to-session">
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
<div class="metadata-item direct-to-session">
    <label for="step-meta-remark" class="header3 metadata-item-title">
        <div>Примечания</div>
        <span class="content-limit tip-color">2000</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-remark" id="step-meta-remark" rows="8" placeholder="Здесь вы можете написать что-нибудь интересное" maxlength="2000"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ДИСКЛЕЙМЕР -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-disclaimer" class="header3 metadata-item-title">
        <div>Дисклеймер</div>
        <span class="content-limit tip-color">500</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-disclaimer" id="step-meta-disclaimer" rows="4" placeholder="Если в книге содержатся моменты, о которых вы хотите предупредить читателей, впишите это сюда" maxlength="500"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ПОСВЯЩЕНИЕ -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-dedication" class="header3 metadata-item-title">
        <div>Посвящение</div>
        <span class="content-limit tip-color">500</span>
    </label>
    <div class="ui field">
        <textarea name="step-meta-dedication" id="step-meta-dedication" rows="4" placeholder="Если книга посвящена кому-либо или чему-либо, напишите об этом здесь" maxlength="500"></textarea>
    </div>
    <div class="input-error"></div>
</div>


<div class="header2">Метаданные</div>

<div class="metadata-row-items">
    <!-- КАТЕГОРИЯ -->
    <div class="metadata-item direct-to-session">
        <div class="header3 metadata-item-title">
            <div>Категория <span class="required-symbol">*</span></div>
        </div>
        <div class="input-block-list" id="step-meta-relation">
            <? foreach ($relations as $relation) {
                $relation_checked = $relation->id == $create_relation ? 'checked' : ''; ?>
                <label class="ui choice-input-block">
                    <input type="radio" name="relation" value="<?=$relation->id?>" <?=$relation_checked?>>
                    <span><?=$relation->title?></span>
                </label>
            <?}?>
        </div>
        <div class="input-error"></div>
    </div>

    <!-- РЕЙТИНГ -->
    <div class="metadata-item direct-to-session">
        <div class="header3 metadata-item-title" id="step-meta-rating">
            <div>Рейтинг <span class="required-symbol">*</span></div>
        </div>
        <div class="input-block-list" id="step-meta-rating">
            <? foreach ($ratings as $rating) {
                $rating_checked = $rating->id == $create_rating ? 'checked' : ''; ?>
                <label class="ui choice-input-block">
                    <input type="radio" name="rating" value="<?=$rating->id?>" <?=$rating_checked?>>
                    <span><?=$rating->title?></span>
                </label>
            <?}?>
        </div>
        <div class="input-error"></div>
    </div>

    <!-- ПЛАНИРУЕМЫЙ РАЗМЕР -->
    <div class="metadata-item direct-to-session">
        <div class="header3 metadata-item-title" id="step-meta-plan_size">
            <div>Планируемый размер <span class="required-symbol">*</span></div>
        </div>
        <div class="input-block-list" id="step-meta-plan_size">
            <? foreach ($plan_sizes as $plan_size) {
                $plan_size_checked = $plan_size->id == $create_plan_size ? 'checked' : ''; ?>
                <label class="ui choice-input-block">
                    <input type="radio" name="plan_size" value="<?=$plan_size->id?>" <?=$plan_size_checked?>>
                    <span><?=$plan_size->title?></span>
                </label>
            <?}?>
        </div>
        <div class="input-error"></div>
    </div>
</div>


<!-- ЖАНРЫ -->
<div class="metadata-item chosen-items-to-session">
    <div class="header3 metadata-item-title">
        <div>Жанры</div>
        <span class="content-limit tip-color">5</span>
    </div>
    <div class="metadata-item-types" type="genre">
        <div class="metadata-item-type" meta-type="0">Все</div>
        <? foreach ($genre_types as $genre_type) { ?>
            <div class="metadata-item-type" meta-type="<?=$genre_type->id?>"><?=$genre_type->title?></div>
        <?}?>
    </div>
    <div class="metadata-item-selected <?=$create_genres_hidden?>">
        <? if ($create_genres) :
            foreach ($create_genres as $create_genre) { ?>
                <div class="metadata-item-selected-unit" meta="<?=$create_genre->id?>"><?=$create_genre->title?> <?=cancel_icon_class?></div>
            <? }
        endif; ?>
    </div>
    <div class="field-with-dropdown">
        <div class="ui field"><input type="text" name="step-meta-genres" id="step-meta-genres" placeholder="Введите первые несколько символов..." maxlength="150"></div>
    </div>
    <div class="input-error"></div>
</div>


<!-- ТЕГИ -->
<div class="metadata-item chosen-items-to-session">
    <div class="header3 metadata-item-title">
        <div>Теги</div>
        <span class="content-limit tip-color">20</span>
    </div>
    <div class="metadata-item-types" type="tag">
        <div class="metadata-item-type" meta-type="0">Все</div>
        <? foreach ($tag_types as $tag_type) { ?>
            <div class="metadata-item-type" meta-type="<?=$tag_type->id?>"><?=$tag_type->title?></div>
        <?}?>
    </div>
    <div class="metadata-item-selected <?=$create_tags_hidden?>">
        <? if ($create_tags) :
            foreach ($create_tags as $create_tag) { ?>
                <div class="metadata-item-selected-unit" meta="<?=$create_tag->id?>"><?=$create_tag->title?> <?=cancel_icon_class?></div>
            <? }
        endif; ?>
    </div>
    <div class="field-with-dropdown">
        <div class="ui field"><input type="text" name="step-meta-tags" id="step-meta-tags" placeholder="Введите первые несколько символов..." maxlength="150"></div>
    </div>
    <div class="input-error"></div>
</div>
