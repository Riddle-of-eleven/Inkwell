<?php

/* @var $this yii\web\View */
/* @var $book Book*/

use app\models\Tables\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\i18n\Formatter;

//VarDumper::dump($book->accessToBooks[0]->, 10, true);
?>


<div class="block book-preview">
    <div class="book-preview-sidebar">
        <div class="side-buttons">
            <?= Html::a(edit_icon, Url::toRoute(['author/modify/define-modify', 'book' => $book->id]), ['class' => 'ui button very-small-button']) ?>
            <?= Html::a(new_chapter_icon, Url::to(['author/modify/add-chapter']), ['class' => 'ui button very-small-button']) ?>
            <!--<div class="ui button very-small-button"><?= link_deployed_code_icon ?></div>
            <div class="ui button very-small-button"><?= branch_icon ?></div>-->
        </div>
        <div class="line"></div>
        <div class="side-buttons">
            <div class="ui button very-small-button danger-button"><?= delete_icon ?></div>
        </div>
    </div>
    <div class="vertical-line"></div>

    <div class="book-preview-content">
        <div class="book-preview-content-container">
            <div class="book-preview-main-meta">
                <div class="creators">
                    <div class="creator">
                        <div class="creator-title">Автор:</div>
                        <div class="creator-name"><?=$book->user->login?></div>
                    </div>
                    <? if ($book->accessToBooks) :
                        if ($book->accessToBooks[0]->coauthor) : ?>
                            <div class="creator">
                                <div class="creator-title">Соавтор:</div>
                                <div class="creator-name"><?=$book->accessToBooks[0]->coauthor->login?></div>
                            </div>
                        <? endif;
                        if ($book->accessToBooks[0]->beta) : ?>
                            <div class="creator">
                                <div class="creator-title">Бета:</div>
                                <div class="creator-name"><?=$book->accessToBooks[0]->beta->login?></div>
                            </div>
                        <? endif;
                        if ($book->accessToBooks[0]->gamma) : ?>
                            <div class="creator">
                                <div class="creator-title">Гамма:</div>
                                <div class="creator-name"><?=$book->accessToBooks[0]->gamma->login?></div>
                            </div>
                        <? endif;
                     endif; ?>
                </div>
            </div>

            <div class="book-preview-info-cover">
                <div class="book-preview-info">
                    <?= Html::a($book->title, Url::toRoute(['author/modify/define-modify', 'book' => $book->id]), ['class' => 'book-preview-title header1']) ?>
                    <div class="info-pairs">
                        <div class="info-pair"><div class="info-key">Количество частей:</div><?=count($book->chapters)?></div>
                        <div class="info-pair"><div class="info-key">Дата создания:</div>
                            <?  $formatter = new Formatter();
                            echo $formatter->asDate($book->created_at, 'd MMMM yyyy');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="book-preview-cover">
                </div>
            </div>

            <div class="publication-stats">
                <div class="publication-stat"><?= visibility_icon ?> Просмотры <div><?=count($book->viewHistories)?></div></div>
                <div class="publication-stat"><?= favorite_icon ?> Лайки <div><?=count($book->likes)?></div></div>
                <div class="publication-stat"><?= chat_bubble_icon ?> Комментарии <div><?=count($book->comments)?></div></div>
                <div class="publication-stat"><?= chat_icon ?> Рецензии <div><?=count($book->reviews)?></div></div>
                <div class="publication-stat"><?= list_alt_icon ?> Подборки <div><?=count($book->bookCollections)?></div></div>
            </div>
        </div>

        <div class="book-preview-actions">
            <? $preview_class = $book->is_draft == 1 ? ' disabled-button' : '' ?>
            <?=Html::a(file_open_icon . 'Посмотреть книгу', Url::to(['main/book', 'id' => $book->id]), [
                'class' => 'ui button icon-button' . $preview_class,
                'id' => 'preview-book'
            ])?>
            <!--<a href="" class="ui button icon-button"><?= file_open_icon ?>Статистика</a>-->
        </div>

    </div>


    <? if ($book->cover) : ?>
        <div class="vertical-line"></div>
        <div class="book-preview-cover-actions">
            <?=Html::img('@web/images/covers/uploads/' . $book->cover, ['class' => 'side-cover'])?>
            <!--<div class="cover-actions">
                <a href="" class="ui button icon-button"><?= imagesmode_icon?>Изменить</a>
                <a href="" class="ui button small-button danger-button"><?= hide_image_icon ?></a>
            </div>-->
        </div>
    <? endif; ?>
</div>