<?php
/* @var Book $book */
/* @var _ContentData $content */
/* @var $like */
/* @var $read */
/* @var $read_later */
/* @var $favorite */
/* @var $awarded */

/* @var $model */

/* @var ComplaintReason[] $complaint_reasons */

$this->title = $book->title;

use app\models\_ContentData;
use app\models\Tables\Book;
use app\models\Tables\ComplaintReason;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->registerCssFile("@web/css/parts/book/book.css");
$this->registerCssFile("@web/css/dashboards/steps.css");
$this->registerJsFile('@web/js/ajax/interaction.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/common/collections.js', ['depends' => [\yii\web\JqueryAsset::class]]);

//VarDumper::dump($book->characters, 10, true);
//die;


$formatter = new Formatter();


// взаимодействия
if (!Yii::$app->user->isGuest) {
    $like_class = $like ? 'filled-button' : '';
    $read_class = $read ? 'filled-button' : '';
    $read_later_class = $read_later ? 'filled-button' : '';

    if ($read) {
        $read_later_disabled = 'disabled';
        $read_later_disabled_class = 'inactive-button';
    } else {
        $read_later_disabled = '';
        $read_later_disabled_class = '';
    }

    if ($read_later) {
        $read_disabled = 'disabled';
        $read_disabled_class = 'inactive-button';
    } else {
        $read_disabled = '';
        $read_disabled_class = '';
    }

    $favorite_class = $favorite ? 'filled-button' : '';
    $favorite_text = $favorite ? 'В избранном' : 'Добавить в избранное';

    $awarded_class = $awarded ? 'filled-button' : '';
    $awarded_text = $awarded ? 'Награждено' : 'Наградить';
    $awarded_block = $awarded ? '' : 'hidden';
}


// размер и то, что его касается
$chapters = count($book->chapters);
$remainder = $chapters % 10;
if ($remainder == 1) $chapters_name = 'часть';
else if ($remainder >= 2 && $remainder <= 4) $chapters_name = 'части';
else if ($remainder >= 5) $chapters_name = 'частей';
else if ($remainder == 0) $chapters_name = 'частей';

$symbols = 0;
if ($chapters) {
    foreach ($book->chapters as $chapter) {
        if ($chapter->content) $symbols += mb_strlen($chapter->content);
    }
}
$remainder = $symbols % 10;
if ($remainder == 1) $symbols_name = 'знак';
else if ($remainder >= 2 && $remainder <= 4) $symbols_name = 'знака';
else if ($remainder >= 5) $symbols_name = 'знаков';
else if ($remainder == 0) $symbols_name = 'знаков';
$symbols_word = '';
if ($symbols >= 1000) {
    $symbols = round($symbols / 1000);
    $symbols_word = 'тыс.';
    $symbols_name = 'знаков';
}


$words = 0;
if ($chapters) {
    foreach ($book->chapters as $chapter) {
        if ($chapter->content) $words += count(explode(' ', $chapter->content));
    }
}
$remainder = $words % 10;
if ($remainder == 1) $words_name = 'слово';
else if ($remainder >= 2 && $remainder <= 4) $words_name = 'слова';
else if ($remainder >= 5) $words_name = 'слов';
else if ($remainder == 0) $words_name = 'слов';
$words_word = '';
if ($words >= 1000) {
    $words = round($words / 1000);
    $words_word = 'тыс.';
    $words_name = 'слов';
}


// статистика по взаимодействиям
$likes = count($book->likes);
$views = count($book->viewHistories);
$collections = count($book->bookCollections);


// пейринги
$pairings = $book->pairings;

?>

<!-- СОЗДАНИЕ ПОДБОРОК -->
<dialog class="to-collection block modal">
    <div class="close-button"><?=close_icon?></div>
    <div class="modal-container" id="regular-modal">
        <div class="header2">Добавить в существующую подборку</div>
        <div class="collections-container"></div>
        <div class="line-centered-text">
            <div class="line"></div>
            <div class="line-text">или</div>
            <div class="line"></div>
        </div>
        <button class="ui button icon-button collection-create"><?=list_alt_add_icon?>Создать новую подборку</button>
    </div>

    <div class="modal-container" id="add-modal"></div>
</dialog>


<!-- ЖАЛОБА НА КНИГУ -->
<dialog class="block modal" id="complaint-dialog" data-book="<?=$book->id?>">
    <div class="close-button"><?=close_icon?></div>
    <div class="modal-container" id="regular-modal">
        <div class="header2">Пожаловаться на книгу</div>
        <!--<div class="head-article">Выберите причину, по которой вы хотите пожаловаться на книгу</div>-->
        <div class="metadata-item">
            <div class="header3">Причина блокировки</div>
            <? if ($complaint_reasons)
                foreach ($complaint_reasons as $complaint_reason) : ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="complaint" value="<?=$complaint_reason->id?>">
                        <span>
                            <div class="title-description">
                                <?=$complaint_reason->title?>
                                <div class="tip"><?=$complaint_reason->description?></div>
                            </div>
                        </span>
                    </label>
                <? endforeach; ?>
        </div>
        <div class="ui button icon-button danger-accent-button" id="make-complaint"><?=flag_icon?>Пожаловаться</div>
    </div>
</dialog>


<div class="book-header">
    <div class="book-card">
        <div class="block statistics is_awarded <?=$awarded_block?>">
            Книга награждена за грамотность!
        </div>
        <div class="block main-info">
            <div class="info-header">
                <div class="creators">
                    <div class="creator">
                        <div>Автор:</div>
                        <?= Html::a(Html::encode($book->user->login), Url::to(['main/author', 'id' => $book->user->id]), ['class' => 'highlight-link'])?>
                    </div>
                </div>
                <div class="metas">
                    <div class="main-meta"><?= Html::encode($book->relation0->title) ?></div>
                    <div class="main-meta"><?= Html::encode($book->rating->title) ?></div>
                    <div class="main-meta"><?= Html::encode($book->completeness->title) ?></div>
                </div>
            </div>
            <div class="inner-line"></div>
            <h1 class="header1"><?= Html::encode($book->title)?></h1>
            <div class="info-pairs">

                <!-- ФЭНДОМЫ -->
                <? if ($book->fandoms) : ?>
                    <div class="info-pair">
                        <div class="info-key">Фэндом:</div>
                        <div class="info-value">
                            <? $first = true;
                            foreach ($book->fandoms as $fandom) {
                                if ($first) $first= false;
                                else echo ', ';
                                echo $fandom->title;
                            } ?>
                        </div>
                    </div>
                <? endif; ?>

                <!-- ПЕРВОИСТОЧНИКИ -->
                <? if ($book->origins) : ?>
                    <div class="info-pair">
                        <div class="info-key">Первоисточник:</div>
                        <div class="info-value">
                            <? $first = true;
                            foreach ($book->origins as $origin) {
                                if ($first) $first= false;
                                else echo ', ';
                                echo $origin->title . " ($origin->release_date)";
                            } ?>
                        </div>
                    </div>
                <? endif; ?>

                <!-- ПЕРСОНАЖИ -->
                <? if ($book->characters) : ?>
                    <div class="info-pair">
                        <div class="info-key">Персонажи:</div>
                        <div class="info-value">
                            <? $first = true;
                            foreach ($book->characters as $character) {
                                if ($first) $first= false;
                                else echo ', ';
                                echo $character->full_name;
                            } ?>
                        </div>
                    </div>
                <? endif; ?>

                <!-- ПЕЙРИНГИ -->
                <? if ($book->pairings) :
                    foreach ($book->pairings as $pairing) : ?>
                        <div class="info-pair">
                            <div class="info-key">Пейринг:</div>
                            <div class="info-value">
                                <? $first = true;
                                foreach ($pairing->pairingCharacters as $pairingCharacter) :
                                    if ($first) $first= false;
                                    else echo ' / ';
                                    echo $pairingCharacter->character->full_name;
                                endforeach; ?>
                            </div>
                        </div>
                    <? endforeach;
                endif; ?>
            </div>
            <div class="small-inner-line"></div>
            <div class="info-pairs">

                <!-- ЖАНРЫ -->
                <? if ($book->genres) : ?>
                    <div class="info-pair">
                        <div class="info-key">Жанры:</div>
                        <div class="info-value">
                            <? $first = true;
                            foreach ($book->genres as $genre) {
                                if ($first) $first= false;
                                else echo ', ';
                                echo $genre->title;
                            } ?>
                        </div>
                    </div>
                <? endif; ?>

                <!-- ТЕГИ -->
                <? if ($book->tags) : ?>
                    <div class="info-pair">
                        <div class="info-key">Теги:</div>
                        <div class="info-value">
                            <? $first = true;
                            foreach ($book->tags as $tag) {
                                if ($first) $first= false;
                                else echo ', ';
                                echo $tag->title;
                            } ?>
                        </div>
                    </div>
                <? endif; ?>
            </div>
            <div class="small-inner-line"></div>
            <div class="info-pairs-vertical">

                <!-- ОПИСАНИЕ -->
                <? if ($book->description) : ?>
                    <div class="info-pair-vertical">
                        <div class="info-key">Описание:</div>
                        <div class="info-value"><?= Html::encode($book->description)?></div>
                    </div>
                <? endif; ?>

                <!-- ПРИМЕЧАНИЯ -->
                <? if ($book->remark) : ?>
                    <div class="info-pair-vertical">
                        <div class="info-key">Примечание:</div>
                        <div class="info-value"><?= Html::encode($book->remark)?>.</div>
                    </div>
                <? endif; ?>

                <!-- ПОСВЯЕЩЕНИЕ -->
                <? if ($book->dedication) : ?>
                    <div class="info-pair-vertical">
                        <div class="info-key">Посвящение:</div>
                        <div class="info-value"><?= Html::encode($book->dedication)?></div>
                    </div>
                <? endif; ?>
            </div>

            <!-- ДИСКЛЕЙМЕР -->
            <? if ($book->disclaimer) : ?>
                <div class="info-pair-vertical disclaimer">
                    <div class="info-key key-disclaimer">Дисклеймер:</div>
                    <div class="info-value"><?= Html::encode($book->disclaimer)?></div>
                </div>
            <? endif; ?>

            <div class="inner-line"></div>
            <div class="publication-stats">
                <div class="book-size">
                    <div class="tip-key">Размер:</div>
                    <div class="tip-value">
                        <? if ($book->realSize) : ?>
                            <div class="size-value"><?=$book->realSize->title?></div>
                        <? endif; ?>
                        <div class="vertical-line"></div>
                        <div class="size-value"><?=$chapters . ' ' . $chapters_name?></div>
                        <div class="vertical-line"></div>
                        <div class="size-value"><?=$words . ' ' . $words_word . ' ' . $words_name?></div>
                        <div class="vertical-line"></div>
                        <div class="size-value"><?=$symbols . ' ' . $symbols_word . ' ' . $symbols_name?></div>
                    </div>
                </div>
                <div class="book-date">
                    <div class="tip-key">Дата публикации:</div>
                    <div class="tip-value">
                        <?= $formatter->asDate($book->created_at, 'd MMMM yyyy'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="block statistics">
            <div class="stats-pair"><?= visibility_icon ?><div>Просмотры</div><div><?=$views?></div></div>
            <div class="stats-pair"><?= favorite_icon ?><div>Лайки</div><div><?=$likes?></div></div>
            <!--<div class="stats-pair">
                <?= chat_bubble_icon ?>
                <div>Комментарии</div>
                <div>4</div>
            </div>
            <div class="stats-pair">
                <?= chat_icon ?>
                <div>Рецензии</div>
                <div>1</div>
            </div>-->
            <div class="stats-pair"><?= list_alt_icon ?><div>Подборки</div><div><?=$collections?></div></div>
        </div>

    </div>

    <div class="book-sidebar">
        <? if ($book->cover): ?>
            <div class="book-cover">
                <?=Html::img('@web/images/covers/uploads/' . $book->cover)?>
            </div>
        <? endif; ?>

        <? if (!Yii::$app->user->isGuest) : ?>
        <div class="block book-actions">
            <? if (Yii::$app->user->identity->is_moderator) : ?>
                <div>
                    <div class="ui button button-left-align <?=$awarded_class?>" id="award-interaction"><?=trophy_icon?><?=$awarded_text?></div>
                </div>
                <div class="inner-line"></div>
            <? endif; ?>

            <div>
                <button class="ui button button-left-align <?=@$like_class?>" id="like-interaction"><?= favorite_icon ?>Нравится</button>
                <button class="ui button button-left-align <?=@$read_class?> <?=@$read_disabled_class?>" id="read-interaction" <?=$read_disabled?>><?= priority_icon ?>Прочитано</button>
                <button class="ui button button-left-align <?=@$read_later_class?> <?=@$read_later_disabled_class?>" id="read-later-interaction" <?=$read_later_disabled?>><?= hourglass_icon ?>Прочитать позже</button>
                <button class="ui button button-left-align <?=@$favorite_class?>" id="favorite-book-interaction"><?= bookmarks_icon ?><div class="button-text"><?=$favorite_text?></div></button>
            </div>

            <div class="inner-line"></div>

            <div>
                <!--<button class="ui button button-left-align" id="download-interaction"><?=download_icon?><div class="button-text">Скачать работу</div></button>-->
                <details>
                    <summary class="ui button button-left-align"><?=download_icon?>Скачать работу</summary>
                    <div class="hidden-download">
                        <div class="ui button button-left-align download-interaction" data-format="epub"><?=epub_icon?>В формате EPUB</div>
                        <div class="ui button button-left-align download-interaction" data-format="fb2"><?=fb2_icon?>В формате FB2</div>
                    </div>
                </details>


                <button class="ui button button-left-align" id="collection-interaction"><?=list_alt_icon?>Добавить в подборку</button>
                <!--<div class="tip">Работа уже добавлена в 3 подборки.</div>-->
            </div>

            <div class="inner-line"></div>

            <div>
                <!--<a href="" class="ui button button-left-align danger-button"><?=visibility_off_icon?>Скрыть из ленты</a>-->
                <div class="ui button button-left-align danger-button" id="complaint-interaction"><?=flag_icon?>Пожаловаться</div>
            </div>
        </div>
        <? else : ?>
        <div class="block book-actions">
            <div>
                <details>
                    <summary class="ui button button-left-align"><?=download_icon?>Скачать работу</summary>
                    <div class="hidden-download">
                        <div class="ui button button-left-align download-interaction" data-format="epub"><?=epub_icon?>В формате EPUB</div>
                        <div class="ui button button-left-align download-interaction" data-format="fb2"><?=fb2_icon?>В формате FB2</div>
                    </div>
                </details>
            </div>

            <div class="inner-line"></div>

            <div>
                <div class="ui button button-left-align danger-button" id="complaint-interaction"><?= flag_icon ?>Пожаловаться</div>
            </div>
        </div>
        <? endif; ?>

    </div>
</div>

<div class="inner-line"></div>
<div class="interface-header header-with-element">
    <div class="header2">Оглавление</div>
    <?= Html::a(resume_icon . 'Читать', Url::to(['main/read-book', 'id' => $book->id]), ['class' => 'ui button icon-button'])?>
</div>

<div class="book-toc">
    <? foreach ($content->root as $r) {
        if ($r->is_section) :
    ?>
    <details class="toc-section" open>
        <summary class="block toc-section-title">
            <div class="expand-icon"><?= expand_more_icon ?></div>
            <div class=""><?= $r->title ?></div>
        </summary>
        <? if (array_key_exists($r->id, $content->offspring)) : ?>
        <div class="toc-chapters">
            <? foreach ($content->offspring[$r->id] as $o) { ?>
                <div class="block toc-chapter">
                    <div class="chapter-title"><?= $o->title ?></div>
                    <div class="chapter-meta">
                        <!--<div class="chapter-stats">
                            <div class="stats-pair"><?= visibility_icon ?><div>Просмотры</div><div>261</div></div>
                            <div class="stats-pair"><?= chat_bubble_icon ?><div>Комментарии</div><div>1</div></div>
                        </div>-->
                        <div class="chapter-date">
                            <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($o->created_at, 'd MMMM yyyy'); ?></div></div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
            <? endif; ?>
    </details>

    <? else : ?>
            <div class="block toc-chapter">
                <div class="chapter-title"><?= $r->title ?></div>
                <div class="chapter-meta">
                    <!--<div class="chapter-stats">
                        <div class="stats-pair"><?= visibility_icon ?><div>Просмотры</div><div>261</div></div>
                        <div class="stats-pair"><?= chat_bubble_icon ?><div>Комментарии</div><div>1</div></div>
                    </div>-->
                    <div class="chapter-date">
                        <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($r->created_at, 'd MMMM yyyy'); ?></div></div>
                    </div>
                </div>
            </div>
    <? endif;
    } ?>

</div>
