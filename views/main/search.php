<?php
$this->title = 'Поиск по вкусу';

/* @var View $this */
/* @var Relation[] $relations */
/* @var Rating[] $ratings */
/* @var Size[] $sizes */
/* @var Completeness[] $statuses */
/* @var Type[] $types */

/* @var GenreType[] $genre_types */
/* @var TagType[] $tag_types */

/* @var Book[]|null $books */

/* @var int $chosen_relation */
/* @var int $chosen_rating */
/* @var int $chosen_size */
/* @var int $chosen_status */
/* @var int $chosen_type */
/* @var string $chosen_sort */


use app\models\Tables\Book;
use app\models\Tables\Completeness;
use app\models\Tables\GenreType;
use app\models\Tables\Rating;
use app\models\Tables\Relation;
use app\models\Tables\Size;
use app\models\Tables\TagType;
use app\models\Tables\Type;

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

use app\widgets\BookDisplay;

\app\assets\BookCreateAsset::register($this);

$sort_likes_selected = $chosen_sort == 'likes' ? 'selected' : '';
$sort_date_selected = $chosen_sort == 'date' ? 'selected' : '';
$sort_chapter_selected = $chosen_sort == 'chapter' ? 'selected' : '';

?>

<div class="header1">Поиск по вкусу</div>

<div class="header2">Параметры</div>

<section>
<?= Html::beginForm(Url::to(), 'get') ?>
    <div class="metadata-item direct-to-session">
        <div class="header3">Тип книги</div>
        <div class="input-block-list" id="sort-type">
            <? foreach ($types as $type) :
                $checked = $type->id == $chosen_type ? 'checked' : ''; ?>
                <label class="ui choice-input-block">
                    <input type='radio' name='type' value='<?=$type->id?>' <?=$checked?>>
                    <span>
                        <div class="title-description">
                            <?=$type->title?>
                            <div class="tip"><?=$type->description?></div>
                        </div>
                    </span>
                </label>
            <? endforeach; ?>
        </div>
        <div class="input-error"></div>
    </div>

    <div class="metadata-row-items" style="gap: 10px; justify-content: space-between">
        <!-- КАТЕГОРИЯ -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Категория</div>
            <div class="input-block-list" id="search-relation">
                <? foreach ($relations as $relation) :
                    $checked = $relation->id == $chosen_relation ? 'checked' : ''; ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="relation" value="<?=$relation->id?>" <?=$checked?>>
                        <span><?=$relation->title?></span>
                    </label>
                <? endforeach; ?>
            </div>
            <div class="input-error"></div>
        </div>

        <!-- РЕЙТИНГ -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Рейтинг</div>
            <div class="input-block-list" id="search-rating">
                <? foreach ($ratings as $rating) :
                    $checked = $rating->id == $chosen_rating ? 'checked' : ''; ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="rating" value="<?=$rating->id?>" <?=$checked?>>
                        <span><?=$rating->title?></span>
                    </label>
                <? endforeach; ?>
            </div>
            <div class="input-error"></div>
        </div>

        <!-- РАЗМЕР -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Планируемый размер</div>
            <div class="input-block-list" id="search-size">
                <? foreach ($sizes as $size) :
                    $checked = $size->id == $chosen_size ? 'checked' : ''; ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="size" value="<?=$size->id?>" <?=$checked?>>
                        <span><?=$size->title?></span>
                    </label>
                <? endforeach; ?>
            </div>
            <div class="input-error"></div>
        </div>

        <!-- СТАТУСЫ ЗАВЕРШЁННОСТИ -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Статус завершённости</div>
            <div class="input-block-list" id="search-status">
                <? foreach ($statuses as $status) :
                    $checked = $status->id == $chosen_status ? 'checked' : ''; ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="status" value="<?=$status->id?>" <?=$checked?>>
                        <span><?=$status->title?></span>
                    </label>
                <? endforeach; ?>
            </div>
            <div class="input-error"></div>
        </div>
    </div>

    <!--<div class="metadata-item">
        <div class="header3 metadata-item-title">Жанры</div>
        <div class="metadata-item-types" type="genre">
            <div class="metadata-item-type" meta-type="0">Все</div>
            <? foreach ($genre_types as $genre_type) { ?>
                <div class="metadata-item-type" meta-type="<?=$genre_type->id?>"><?=$genre_type->title?></div>
            <?}?>
        </div>
        <div class="metadata-item-selected hidden"></div>
        <div class="field-with-dropdown">
            <div class="ui field"><input type="text" name="search-genres" id="search-genres" placeholder="Введите первые несколько символов..." maxlength="150"></div>
        </div>
        <div class="input-error"></div>
    </div>-->


    <!-- ТЕГИ -->
    <!--<div class="metadata-item">
        <div class="header3 metadata-item-title">Теги</div>
        <div class="metadata-item-types" type="tag">
            <div class="metadata-item-type" meta-type="0">Все</div>
            <? foreach ($tag_types as $tag_type) { ?>
                <div class="metadata-item-type" meta-type="<?=$tag_type->id?>"><?=$tag_type->title?></div>
            <?}?>
        </div>
        <div class="metadata-item-selected hidden"></div>
        <div class="field-with-dropdown">
            <div class="ui field"><input type="text" name="search-tags" id="search-tags" placeholder="Введите первые несколько символов..." maxlength="150"></div>
        </div>
        <div class="input-error"></div>
    </div>-->


    <!-- СОРТИРОВКА РЕЗУЛЬТАТОВ -->
    <div class="metadata-item">
        <div class="header3 metadata-item-title">Сортировать результаты</div>
        <div class="ui field" id="search-sort">
            <select name="sort" id="search-sort">
                <option value="likes" <?=$sort_likes_selected?>>По оценкам читателей</option>
                <option value="date" <?=$sort_date_selected?>>По дате публикации</option>
                <option value="chapter" <?=$sort_chapter_selected?>>По количеству глав</option>
            </select>
        </div>
        <div class="input-error"></div>
    </div>


    <?= Html::submitButton(action_key_icon . 'Показать результаты', [
        'class' => 'ui button icon-button',
    ]) ?>
<?= Html::endForm() ?>
</section>

<div class="inner-line"></div>

<div class="header2">Результаты поиска</div>

<? if ($chosen_type || $chosen_sort || $chosen_status || $chosen_size || $chosen_rating || $chosen_relation) :
    if ($books) :
        foreach ($books as $book) {
            echo BookDisplay::widget(['book' => $book]);
        }
    else : ?>
        <div class="center-container tip-color">Ничего не найдено</div>
    <? endif;
    else : ?>
        <div class="center-container tip-color">Выберите интересующий параметр и нажмите "Показать результаты", чтобы найти книги по вкусу</div>
<? endif;