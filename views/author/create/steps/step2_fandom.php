<?php
/** @var yii\web\View $this */

/* @var $create_book_type */
/* @var Fandom[] $create_fandoms */
/* @var $create_origins */
/* @var Character[] $create_characters */
/* @var Tag[] $create_fandom_tags */

/* @var $create_pairings */

/* @var Type[] $book_types */
/* @var Relationship[] $relationships */

use app\models\Tables\Type;
use app\models\Tables\Fandom;
use app\models\Tables\Character;
use app\models\Tables\Tag;
use app\models\Tables\Relationship;

//use yii\helpers\VarDumper;

//VarDumper::dump($create_pairings, 10, true);

$fandom_section_class = $create_book_type == 2 ? '' : 'hidden';
$create_fandoms_hidden = $create_fandoms ? '' : 'hidden';
$create_characters_hidden = $create_characters ? '' : 'hidden';
$create_pairings_hidden = $create_pairings ? '' : 'hidden';
$create_fandom_tags_hidden = $create_fandom_tags ? '' : 'hidden';

$fandom_replacement_class = $create_fandoms ? 'hidden' : '';
$fandom_depend_class = $create_fandoms ? '' : 'hidden';

//VarDumper::dump($create_fandom_tags, 10, true);
?>

<div class="header2">Тип книги</div>
<div class="head-article">Если ваша книга является фанфиком, у вас появится возможность указать фэндом, первоисточники, персонажей и пейринги.</div>
<div class="metadata-item direct-to-session">
    <div class="input-block-list" id="step-meta-book_type">
        <? foreach ($book_types as $book_type) {
            $book_type_checked = $book_type->id == $create_book_type ? 'checked' : '';?>
            <label class="ui choice-input-block">
                <input type='radio' name='book_type' id="book_type-<?=$book_type->id?>" value='<?=$book_type->id?>' <?=$book_type_checked?>>
                <span><?=$book_type->title?></span>
            </label>
        <?}?>
    </div>
    <div class="input-error"></div>
</div>

<div class="book-type-depend <?=$fandom_section_class?>">
    <div class="header2">Фэндомные сведения</div>
    <div class="head-article">Для каждого фэндома можно указать сколько угодно первоисточников</div>

    <!-- ФЭНДОМ -->
    <div class="metadata-item chosen-items-to-session fandom-item">
        <div class="header3 metadata-item-title">
            <div>Фэндом и первоисточники <span class="required-symbol">*</span></div>
            <span class="content-limit tip-color">5</span>
        </div>
        <div class="field-with-dropdown">
            <div class="ui field"><input type="text" name="step-meta-fandoms" id="step-meta-fandoms" placeholder="Введите первые несколько символов" maxlength="150"></div>
        </div>
        <div class="metadata-item-selected metadata-fandom-selected <?=$create_fandoms_hidden?>" id="step-meta-origins">
            <? if ($create_fandoms) :
                foreach ($create_fandoms as $create_fandom) { ?>
                    <details class="metadata-item-selected-unit metadata-fandom-selected-unit" meta="<?=$create_fandom->id?>">
                        <summary class="block select-header">
                            <div class="select-header-expand"><div class="expand-icon"><?=expand_more_icon?></div><?=$create_fandom->title?></div>
                            <div class="ui button small-button danger-accent-button remove-fandom"><?=delete_icon_class?></div>
                        </summary>
                        <div class="inner-details-field">
                            <? $origins = $create_fandom->origins;
                                if ($origins) : ?>
                                    <div class="inner-details-choice self-table">
                                        <div></div>
                                        <div>Название</div>
                                        <div>Тип медиа</div>
                                        <div>Год создания</div>
                                        <div>Создатель</div>
                                    </div>
                                    <? foreach ($origins as $origin) {

                                        $origin_checked = in_array($origin->id, $create_origins) ? 'checked' : ''; ?>
                                        <label class="inner-details-choice">
                                            <input type='checkbox' name='origins' id="origin-<?=$origin->id?>" value='<?=$origin->id?>' <?=$origin_checked?>>
                                            <span>
                                                <div><?=$origin->title?></div>
                                                <div><?=$origin->media->title?></div>
                                                <div><?=$origin->release_date?></div>
                                                <div><?=$origin->creator?></div>
                                            </span>
                                        </label>
                                    <?}?>
                                <? else : ?>
                                    <div class="empty-origin tip-color">У этого фэндома нет первоисточников</div>
                            <? endif;?>
                        </div>
                    </details>
                <? }
            endif;?>
        </div>
        <div class="input-error"></div>
    </div>


    <!-- ПЕРСОНАЖИ -->
    <div class="metadata-item chosen-items-to-session">
        <div class="header3 metadata-item-title">
            <div>Персонажи</div>
            <span class="content-limit tip-color fandom-depend <?=$fandom_depend_class?>">20</span>
        </div>
        <div class="metadata-item-selected <?=$create_characters_hidden?>">
            <? if ($create_characters) :
                foreach ($create_characters as $create_character) { ?>
                    <div class="metadata-item-selected-unit" meta="<?=$create_character->id?>"><?=$create_character->full_name?> <?=cancel_icon_class?></div>
                <? }
            endif; ?>
        </div>
        <div class="tip-color fandom-depend-replacement <?=$fandom_replacement_class?>">Сначала выберите фэндом</div>
        <div class="field-with-dropdown">
            <div class="ui field fandom-depend <?=$fandom_depend_class?>"><input type="text" name="step-meta-characters" id="step-meta-characters" placeholder="Введите первые несколько символов" maxlength="150"></div>
        </div>
        <div class="input-error"></div>
    </div>


    <!-- ПЕЙРИНГИ -->
    <div class="metadata-item chosen-items-to-session pairings-item">
        <div class="header3 metadata-item-title">
            <div>Пейринги</div>
            <span class="content-limit tip-color fandom-depend <?=$fandom_depend_class?>">5</span>
        </div>
        <div class="tip-color fandom-depend-replacement <?=$fandom_replacement_class?>">Сначала выберите фэндом</div>
        <div class="ui button icon-button fandom-depend <?=$fandom_depend_class?>" id="step-meta-pairings"><?=new_pairing_icon?>Добавить пейринг</div>
        <div class="metadata-item-selected metadata-pairing-selected <?=$create_pairings_hidden?>">
            <? if ($create_pairings) :
                foreach ($create_pairings as $key => $value) { ?>
                    <div class="pairing-item block" meta="<?=$key?>">
                        <div class="pairing-choice">
                            <div class="field-with-dropdown">
                                <div class="ui field">
                                    <input type="text" name="pairing-characters-input" class="pairing-characters-input" id="step-meta-main-pairing_characters-<?=$key?>" placeholder="Введите первые несколько символов...">
                                </div>
                            </div>
                            <div class="metadata-item-selected pairing-selected-items">
                                <? if ($value['characters']) :
                                    foreach ($value['characters'] as $character) { ?>
                                         <div class="metadata-item-selected-unit" meta="<?=$character->id?>"><?=$character->full_name?> <?=cancel_icon_class?></div>
                                    <? }
                                endif; ?>

                            </div>
                        </div>
                        <div class="ui field field-select">
                            <select name="relationship" id="relationship-<?=$key?>>">
                                <? if ($relationships)
                                    foreach ($relationships as $relationship) {
                                        $relationship_selected = $relationship->id == $value['relationship']->id ? 'selected' : ''; ?>
                                        <option value="<?=$relationship->id?>" <?=$relationship_selected?>><?=$relationship->title?></option>
                                    <?}?>
                            </select>
                        </div>
                        <div class="ui button small-button delete-button danger-accent-button"><?=delete_icon?></div>
                    </div>
                <? }
            endif; ?>
        </div>
        <div class="input-error"></div>
    </div>


    <!-- ФЭНДОМНЫЕ ТЕГИ -->
    <div class="metadata-item chosen-items-to-session">
        <div class="header3 metadata-item-title">
            <div>Фэндомные теги</div>
            <span class="content-limit tip-color fandom-depend <?=$fandom_depend_class?>">5</span>
        </div>
        <div class="head-article fandom-depend <?=$fandom_depend_class?>" style="margin-bottom: 10px">Если у фэндома, который вы выбрали, есть специальные теги, можете добавить их здесь</div>
        <div class="metadata-item-selected <?=$create_fandom_tags_hidden?>">
            <? if ($create_fandom_tags) :
                foreach ($create_fandom_tags as $create_fandom_tag) { ?>
                    <div class="metadata-item-selected-unit" meta="<?=$create_fandom_tag->id?>"><?=$create_fandom_tag->title?> <?=cancel_icon_class?></div>
                <? }
            endif; ?>
        </div>
        <div class="tip-color fandom-depend-replacement <?=$fandom_replacement_class?>">Сначала выберите фэндом</div>
        <div class="field-with-dropdown">
            <div class="ui field fandom-depend <?=$fandom_depend_class?>"><input type="text" name="step-meta-fandom_tags" id="step-meta-fandom_tags" placeholder="Введите первые несколько символов" maxlength="150"></div>
        </div>
        <div class="input-error"></div>
    </div>
</div>
