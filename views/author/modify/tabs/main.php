<?php
/** @var View $this */
/** @var string $modify_title */
/** @var string $modify_description */
/** @var string $modify_remark */
/** @var string $modify_disclaimer */
/** @var string $modify_dedication */


use yii\helpers\Html;
use yii\web\View;

\app\assets\BookCreateAsset::register($this);
$this->registerJs(<<<js
    $(title).val(`$modify_title`);
    $(description).val(`$modify_description`);
    $(remark).val(`$modify_remark`);
    $(disclaimer).val(`$modify_disclaimer`);
    $(dedication).val(`$modify_dedication`);
js, View::POS_END);

?>

<div class="header2">Общая информация</div>

<!-- НАЗВАНИЕ -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-title" class="header3 metadata-item-title">Название</label>
    <div class="ui field"><input type="text" name="step-meta-title" id="step-meta-title" placeholder="Название книги" maxlength="150"></div>
    <div class="input-error"></div>
</div>

<!-- ОПИСАНИЕ -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-description" class="header3 metadata-item-title">Описание</label>
    <div class="ui field">
        <textarea name="step-meta-description" id="step-meta-description" rows="6" placeholder="Расскажите, о чём эта книга" maxlength="800"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ПРИМЕЧАНИЯ -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-remark" class="header3 metadata-item-title">Примечания</label>
    <div class="ui field">
        <textarea name="step-meta-remark" id="step-meta-remark" rows="8" placeholder="Здесь вы можете написать что-нибудь интересное" maxlength="2000"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ДИСКЛЕЙМЕР -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-disclaimer" class="header3 metadata-item-title">Дисклеймер</label>
    <div class="ui field">
        <textarea name="step-meta-disclaimer" id="step-meta-disclaimer" rows="4" placeholder="Если в книге содержатся моменты, о которых вы хотите предупредить читателей, впишите это сюда" maxlength="500"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<!-- ПОСВЯЩЕНИЕ -->
<div class="metadata-item direct-to-session">
    <label for="step-meta-dedication" class="header3 metadata-item-title">Посвящение</label>
    <div class="ui field">
        <textarea name="step-meta-dedication" id="step-meta-dedication" rows="4" placeholder="Если книга посвящена кому-либо или чему-либо, напишите об этом здесь" maxlength="500"></textarea>
    </div>
    <div class="input-error"></div>
</div>

<?= Html::button(save_icon . 'Сохранить изменения', ['class' => 'ui button icon-button']) ?>


<div class="inner-line"></div>

<?php /*

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
                                    $origin_checked = $create_origins ? (in_array($origin->id, $create_origins) ? 'checked' : '') : ''; ?>
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
        <div class="metadata-item-selected fandom-depend <?=$create_characters_hidden?>">
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
        <div class="metadata-item-selected metadata-pairing-selected fandom-depend <?=$create_pairings_hidden?>">
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
        <div class="metadata-item-selected fandom-depend <?=$create_fandom_tags_hidden?>">
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
            <? if($create_cover) echo Html::img('@web/images/covers/uploads/' . $create_cover, ['class' => 'crop-result block']); ?>
        </div>
        <div class="cover-buttons">
            <div class="ui button icon-button danger-accent-button" id="button-restore"><?=hide_image_icon?>Удалить обложку</div>
            <div class="ui button icon-button <?=$crop_hidden?>" id="button-crop"><?=imagesmode_icon?>Сохранить результат</div>
        </div>
    </div>
</div>

 */