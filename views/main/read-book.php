<?php
$this->title = Yii::$app->name.' – книга';

/* @var \app\models\Tables\Chapter $chapters */
/* @var $pages */
/* @var \app\models\Tables\Book $book */

$this->registerCssFile("@web/css/parts/book/reader.css");

use app\models\Tables\Book;
use app\models\Tables\Chapter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\widgets\LinkPager;

$formatter = new Formatter();

echo LinkPager::widget(['pagination' => $pages]);

?>

<? foreach ($chapters as $chapter) { ?>


<div class="center-container reader">
    <!--<div class="reading-progress">
        <div class="progress-bar"><div class="current-progress"></div></div>
        <div class="tip">24%</div>
    </div>-->

    <div class="reader-header block">
        <div class="reader-header-left">
            <button class="ui button small-button"><?=keyboard_double_arrow_left_icon?></button>
            <div class="header2"><?=$book->title?></div>
        </div>
        <div class="reader-header-right">
            <div class="action-buttons">
                <button class="ui button small-button"><?=favorite_icon?></button>
                <button class="ui button small-button"><?=list_alt_add_icon?></button>
                <button class="ui button small-button"><?=palette_icon?></button>
            </div>
            <div class="vertical-line"></div>
            <?=Html::a(cancel_icon . 'Выйти из читалки', Url::to(['main/book', 'id' => $book->id]), ['class' => 'ui button icon-button danger-accent-button'])?>
        </div>
    </div>

    <div class="reader-navigation">
        <button class="ui button icon-button"><?=previous_icon?>Предыдущая глава</button>
        <button class="ui button icon-button"><?=news_icon?>Оглавление</button>
        <button class="ui button icon-button"><?=resume_icon?>Следующая глава</button>
    </div>

    <div class="reader-content block">
        <div class="reader-book-header">
            <div class="header2"><?=$chapter->title?></div>
            <div class="tip"><?=$formatter->asDatetime($chapter->created_at, "d MMMM yyyy, HH.m");?></div>
        </div>

        <div class="reader-book-text">
            <?
                $explodes = explode('<tab>', $chapter->content);
                $implode = '';
                foreach ($explodes as $explode) $implode .= "<p>$explode</p>";
                echo $implode;
            ?>
        </div>
    </div>

    <div class="reader-navigation">
        <button class="ui button icon-button"><?=previous_icon?>Предыдущая глава</button>
        <button class="ui button icon-button"><?=news_icon?>Оглавление</button>
        <button class="ui button icon-button"><?=resume_icon?>Следующая глава</button>
    </div>

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


