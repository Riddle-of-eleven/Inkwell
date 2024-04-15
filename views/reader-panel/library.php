<?php
$this->title = Yii::$app->name.' – библиотека';

/* @var $books */


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
    <div class="tab" data-tab="4"><div><?=bookmarks_icon?></div>Избранное</div>
    <div class="tab" data-tab="2"><div><?=priority_icon?></div>Прочитанные</div>
    <div class="tab" data-tab="3"><div><?=hourglass_icon?></div>Прочитать позже</div>
</div>

<div class="tab-contents">
    <section class="tab-content active-tab" data-tab="1">
        <? if ($books)
            foreach ($books as $book) {
                echo BookDisplay::widget(['data' => $book]);
            }
        else echo '<div class="center-container tip-color">Вы не добавили в понравившееся ни одной книги</div>'; ?>
    </section>
    <section class="tab-content" data-tab="2"></section>
    <section class="tab-content" data-tab="3"></section>
    <section class="tab-content" data-tab="4"></section>
</div>