<?php
/** @var yii\web\View $this */

/* @var $create_book_type */
/* @var Fandom[] $create_fandoms */
/* @var $create_origins */


/* @var Type[] $book_types */

use app\models\Tables\Type;
use app\models\Tables\Fandom;

use yii\helpers\VarDumper;

//VarDumper::dump($create_fandoms, 10, true);

$fandom_section_class = $create_book_type == 2 ? '' : 'hidden';
$create_fandoms_hidden = $create_fandoms ? '' : 'hidden';
?>

<div class="header2">Тип книги</div>
<div class="head-article tip-color">Если ваша книга является фанфиком, у вас появится возможность указать фэндом, первоисточники, персонажей и пейринги.</div>
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
    <div class="head-article tip-color">Для каждого фэндома можно указать сколько угодно первоисточников</div>

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
    <div class="metadata-item">
        <div class="header3 metadata-item-title">
            <div>Персонажи</div>
            <span class="content-limit tip-color hidden">20</span>
        </div>
        <div class="metadata-item-selected hidden"></div>
        <div class="tip-color">Сначала выберите фэндом</div>
        <!--<div class="ui field"><input type="text" name="step-meta-characters" id="step-meta-characters" placeholder="Введите первые несколько символов" maxlength="150"></div>-->
        <div class="input-error"></div>
    </div>

    <!-- ПЕЙРИНГИ -->
    <div class="metadata-item">
        <div class="header3 metadata-item-title">
            <div>Пейринги</div>
            <span class="content-limit tip-color hidden">5</span>
        </div>
        <div class="metadata-item-selected hidden"></div>
        <div class="tip-color">Сначала выберите фэндом</div>
        <!--<div class="ui field"><input type="text" name="step-meta-pairing" id="step-meta-pairing" placeholder="Введите первые несколько символов" maxlength="150"></div>-->
        <div class="input-error"></div>
    </div>
</div>
