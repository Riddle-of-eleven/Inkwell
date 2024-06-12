<?php

/* @var $this yii\web\View */
/* @var $book Book */

use app\models\_BookData;
use app\models\Tables\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\i18n\Formatter;

$book_cover_hidden = $book->cover != '' ? '' : 'hidden';

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

?>


<div class="block book-preview">
    <div class="book-preview-sidebar">
        <? if (Yii::$app->user->isGuest) echo '<div class="side-buttons"><div class="ui button very-small-button danger-button">' . flag_icon .'</div></div>';
        else { ?>
            <div class="side-buttons">
                <div class="ui button very-small-button"><?=favorite_icon?></div>
                <div class="ui button very-small-button"><?=priority_icon?></div>
                <div class="ui button very-small-button"><?=hourglass_icon?></div>
            </div>
            <div class="line"></div>
            <div class="side-buttons">
                <div class="ui button very-small-button danger-button"><?=flag_icon?></div>
            </div>
        <? } ?>
    </div>
    <div class="vertical-line"></div>
    <div class="book-preview-content">
        <div class="book-preview-main-meta">
            <div class="creators">
                <div class="creator">
                    <div class="creator-title">Автор:</div>
                    <?= Html::a(Html::encode($book->user->login), Url::to(['main/author', 'id' => $book->user->id]), ['class' => 'creator-name'])?>
                </div>
                <!--<div class="creator">
                    <div class="creator-title">Редакторы:</div>
                    <div class="creator-name">Silmaril, Cactus</div>
                </div>-->
            </div>
            <div class="accent-metas">
                <div class="accent-meta"><?= Html::encode($book->relation0->title) ?></div>
                <div class="accent-meta"><?= Html::encode($book->rating->title) ?></div>
                <div class="accent-meta"><?= Html::encode($book->completeness->title) ?></div>
            </div>
        </div>
        <div class="line"></div>


        <div class="book-preview-info-cover">
            <div class="book-preview-info">
                <div class="book-preview-title header1"><?=Html::a($book->title, Url::to(['main/book', 'id' => $book->id]))?></div>
                <div class="small-inner-line"></div>
                <div class="info-pairs">
                    <div class="info-pair">
                        <div class="info-key">Фэндом:</div>
                        <? if ($book->fandoms) :
                            foreach ($book->fandoms as $fandom) {
                                echo '<div class="info-value">' . $fandom->title . '</div>';
                            }
                            else :
                                echo '<div class="info-value">Ориджинал</div>';
                        endif; ?>
                    </div>
                    <? if ($book->origins) : ?>
                        <div class="info-pair">
                            <div class="info-key">Первоисточник:</div>
                                <? foreach ($book->origins as $origin) {
                                    echo '<div class="info-value">' . $origin->title . ' (' . $origin->release_date .')'. '</div>';
                                }?>
                        </div>
                    <? endif; ?>
                    <?if ($book->characters) : ?>
                        <div class="info-pair">
                            <div class="info-key">Персонажи:</div>
                            <div class="info-value">
                                <? $first = true;
                                foreach ($book->characters as $character) {
                                    if ($first) $first= false;
                                    else echo ', ';
                                    echo $character->full_name;
                                }?>
                            </div>
                        </div>
                    <? endif; ?>
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

                <div class="book-preview-description"><?= Html::encode($book->description)?></div>

            </div>
            <div class="book-preview-cover <?=$book_cover_hidden?>">
                <?=Html::img('@web/images/covers/uploads/' . $book->cover)?>
            </div>
        </div>



        <div class="line"></div>


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
                    <?  $formatter = new Formatter();
                        echo $formatter->asDate($book->created_at, 'd MMMM yyyy');
                    ?>
                </div>
            </div>


            <div class="book-evaluation">
                <div class="evaluation-pair highlight-svg"><?= favorite_icon . count($book->likes)?></div>
                <!--<div class="evaluation-pair"><?= chat_bubble_icon ?> 32</div>-->
            </div>
        </div>

    </div>
</div>