<?php
$this->title = Yii::$app->name.' – библиотека';

/* @var $liked_books */
/* @var $read_books */
/* @var $read_later_books */
/* @var $favorite_books */


use yii\helpers\VarDumper;
use app\widgets\BookDisplay;

?>

<div class="dashboard-header">
    <div>
        <h1>Библиотека</h1>
        <div class="tip-color">Здесь вы видите ваши любимые книги и фэндомы, а также читательские планы.</div>
    </div>
</div>


<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><div><?=favorite_icon?></div>Понравившиеся</div>
    <div class="tab" data-tab="2"><div><?=bookmarks_icon?></div>Избранное</div>
    <div class="tab" data-tab="3"><div><?=priority_icon?></div>Прочитанные</div>
    <div class="tab" data-tab="4"><div><?=hourglass_icon?></div>Прочитать позже</div>
</div>

<div class="tab-contents">
    <section class="tab-content active-tab" data-tab="1">
        <? if ($liked_books)
            foreach ($liked_books as $book) {
                echo BookDisplay::widget(['data' => $book]);
            }
        else echo '<div class="center-container tip-color">Вы не добавили в понравившееся ни одной книги</div>'; ?>
    </section>
    <section class="tab-content" data-tab="2">
        <? if ($favorite_books)
            foreach ($favorite_books as $book) {
                echo BookDisplay::widget(['data' => $book]);
            }
        else echo '<div class="center-container tip-color">Вы не добавили в избранное ни одной книги</div>'; ?>
    </section>
    <section class="tab-content" data-tab="3">
        <? if ($read_books)
            foreach ($read_books as $book) {
                echo BookDisplay::widget(['data' => $book]);
            }
        else echo '<div class="center-container tip-color">Вы не добавили в прочитанное ни одной книги</div>'; ?></section>
    <section class="tab-content" data-tab="4">
        <? if ($read_later_books)
            foreach ($read_later_books as $book) {
                echo BookDisplay::widget(['data' => $book]);
            }
        else echo '<div class="center-container tip-color">Вы не отложили на потом ни одной книги</div>'; ?>
    </section>
</div>