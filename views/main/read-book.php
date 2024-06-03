<?php
/* @var View $this*/
/* @var Chapter $chapters */
/* @var $pages */
/* @var Book $book */
/* @var string $font */

$this->title = 'Книга "' . $book->title . '"';

$this->registerCssFile("@web/css/parts/book/reader.css");
$this->registerJsFile('@web/js/parts/reader.js', ['depends' => [\yii\web\JqueryAsset::class]]);

if ($font) $this->registerCssFile("@web/css/parts/book/reader_$font.css");
else $this->registerCssFile("@web/css/parts/book/reader_nunito.css");

use yii\web\View;
use app\models\Tables\Book;
use app\models\Tables\Chapter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\widgets\LinkPager;

$formatter = new Formatter();
$linkpager = LinkPager::widget([
    'pagination' => $pages,
    'prevPageLabel' => previous_icon . 'Предыдущая глава',
    'nextPageLabel' => resume_icon . 'Следующая глава',
    'maxButtonCount' => 0,
    'prevPageCssClass' => 'ui button icon-button',
    'nextPageCssClass' => 'ui button icon-button',
    'disabledPageCssClass' => 'disabled-button',
]);

?>

<? foreach ($chapters as $chapter) { ?>

<div class="center-container reader">
    <dialog id="set-appearance" class="block modal">
        <div class="close-button"><?=close_icon?></div>
        <div class="modal-container" id="regular-modal">
            <div class="header2">Настройка оформления читалки</div>

            <div class="header3">Шрифт</div>
            <div class="reader-parameters">
                <div class="block font-block font-nunito" data-font="nunito">
                    <div class="font-preview">Где ёж?</div>
                    <div class="font-family">Стандартный</div>
                </div>
                <div class="block font-block font-anonymous" data-font="anonymous">
                    <div class="font-preview">Где ёж?</div>
                    <div class="font-family">Anonymous Pro</div>
                </div>
                <div class="block font-block font-comfortaa" data-font="comfortaa">
                    <div class="font-preview">Где ёж?</div>
                    <div class="font-family">Comfortaa</div>
                </div>
                <div class="block font-block font-cormorant" data-font="cormorant">
                    <div class="font-preview">Где ёж?</div>
                    <div class="font-family">Cormorant</div>
                </div>
                <div class="block font-block font-roboto" data-font="roboto">
                    <div class="font-preview">Где ёж?</div>
                    <div class="font-family">Roboto</div>
                </div>
            </div>
        </div>
    </dialog>


    <!--<div class="reading-progress">
        <div class="progress-bar"><div class="current-progress"></div></div>
        <div class="tip">24%</div>
    </div>-->

    <div class="reader-header block">
        <div class="reader-header-left">
            <!--<button class="ui button small-button"><?=keyboard_double_arrow_left_icon?></button>-->
            <div class="header2"><?=$book->title?></div>
        </div>
        <div class="reader-header-right">
            <!--<div class="action-buttons">
                <button class="ui button small-button"><?=favorite_icon?></button>
                <button class="ui button small-button"><?=list_alt_add_icon?></button>
                <button class="ui button icon-button"><?=palette_icon?>Настроить внешний вид</button>
            </div>-->

            <button class="ui button icon-button" id="open-set-appearance"><?=palette_icon?>Настроить оформление</button>
            <?=Html::a(cancel_icon . 'Выйти из читалки', Url::to(['main/book', 'id' => $book->id]), ['class' => 'ui button icon-button danger-accent-button'])?>
        </div>
    </div>

    <div class="reader-navigation">
        <!--button class="ui button icon-button"><?=previous_icon?>Предыдущая глава</button>
        <button class="ui button icon-button"><?=news_icon?>Оглавление</button>
        <button class="ui button icon-button"><?=resume_icon?>Следующая глава</button>-->
        <? echo $linkpager ?>
    </div>

    <div class="reader-content block">
        <div class="reader-book-header">
            <div class="header2"><?=$chapter->title?></div>
            <div class="tip"><?=$formatter->asDatetime($chapter->created_at, "d MMMM yyyy, HH:mm");?></div>
        </div>

        <div class="reader-book-text"><?= $chapter->content ?></div>
    </div>

    <div class="reader-navigation"><? echo $linkpager ?></div>

    <!--<div class="line"></div>-->
</div>

<!--<div class="header2">Комментарии</div>

<div class="comment-form">
    <div class="author-avatar"></div>
    <div class="add-comment">
        <textarea name="" id="" rows="3"></textarea>
        <div class="under-comment">
            <div class="tip">Здесь вы можете похвалить автора или высказать критику. Помните, что некорректные комментарии могут быть удалены.</div>
            <div class="ui button icon-button"><?=send_icon?>Отправить</div>
            <div class="symbol-count">2000</div>
        </div>
    </div>
</div>

<div class="comments">
    <div class="comment">
        
    </div>
    <details>
        <summary class="block">
            <div class="expand-icon"><?= expand_more_icon ?></div>
            <div class="">Ответы</div>
        </summary>
        <div class="comment"></div>
    </details>
</div>
-->

<? } ?>


