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


?>

<div class="header1">Поиск по вкусу</div>

<div class="header2">Параметры</div>

<section>
<?= Html::beginForm(Url::to(), 'get') ?>
    <div class="metadata-item direct-to-session">
        <div class="header3">Тип книги</div>
        <div class="input-block-list" id="sort-type">
            <? foreach ($types as $type) : ?>
                <label class="ui choice-input-block">
                    <input type='radio' name='type' value='<?=$type->id?>'>
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
                <? foreach ($relations as $relation) {
                    //$relation_checked = $relation->id == $create_relation ? 'checked' : '';
                    ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="relation" value="<?=$relation->id?>">
                        <span><?=$relation->title?></span>
                    </label>
                <?}?>
            </div>
            <div class="input-error"></div>
        </div>

        <!-- РЕЙТИНГ -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Рейтинг</div>
            <div class="input-block-list" id="search-rating">
                <? foreach ($ratings as $rating) {
                    //$rating_checked = $rating->id == $create_rating ? 'checked' : '';
                    ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="rating" value="<?=$rating->id?>">
                        <span><?=$rating->title?></span>
                    </label>
                <?}?>
            </div>
            <div class="input-error"></div>
        </div>

        <!-- РАЗМЕР -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Планируемый размер</div>
            <div class="input-block-list" id="search-size">
                <? foreach ($sizes as $size) {
                    //$plan_size_checked = $plan_size->id == $create_plan_size ? 'checked' : '';
                    ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="size" value="<?=$size->id?>">
                        <span><?=$size->title?></span>
                    </label>
                <?}?>
            </div>
            <div class="input-error"></div>
        </div>

        <!-- СТАТУСЫ ЗАВЕРШЁННОСТИ -->
        <div class="metadata-item">
            <div class="header3 metadata-item-title">Статус завершённости</div>
            <div class="input-block-list" id="search-status">
                <? foreach ($statuses as $status) {
                    //$plan_size_checked = $plan_size->id == $create_plan_size ? 'checked' : '';
                    ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="status" value="<?=$status->id?>">
                        <span><?=$status->title?></span>
                    </label>
                <?}?>
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
                <option value="likes">По оценкам читателей</option>
                <option value="date">По дате публикации</option>
                <option value="chapter">По количеству глав</option>
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

<? if ($books)
    foreach ($books as $book) {
        echo BookDisplay::widget(['book' => $book]);
    }