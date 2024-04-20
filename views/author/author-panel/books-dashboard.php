<?php
$this->title = Yii::$app->name.' – книги';

/* @var $books_progress*/
/* @var $books_complete*/
/* @var $books_frozen*/
/* @var $books_draft*/
/* @var $books_process*/

use app\widgets\BookDisplay;
use yii\i18n\Formatter;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\widgets\PanelBookDisplay;


/*$this->params['breadcrumbs'][] = ['label' => 'Кабинет автора'];
$this->params['breadcrumbs'][] = 'Книги';*/

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');

?>

<div class="dashboard-header">
    <div>
        <h1>Книги</h1>
        <div class="tip-color">На этой странице отображаются все книги, автором которых вы являетесь.</div>
    </div>
    <?= Html::a(new_book_icon . 'Добавить книгу', Url::to(['main/rand-book']), ['class' => 'ui button icon-button accent-button']) ?>
</div>



<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><div class="tab-number"><?=count($books_progress)?></div>В процессе</div>
    <div class="tab" data-tab="2"><div class="tab-number"><?=count($books_complete)?></div>Завершённые</div>
    <div class="tab" data-tab="3"><div class="tab-number"><?=count($books_frozen)?></div>Замороженные</div>
    <div class="tab" data-tab="4"><div class="tab-number"><?=count($books_draft)?></div>Черновики</div>
    <div class="tab" data-tab="5"><div class="tab-number"><?=count($books_process)?></div>В процессе добавления</div>
</div>

<div class="dashboard-search">
    <div class="ui search-field"><?= search_icon ?><input type="text" placeholder="Поиск"></div>
    <a href="" class="ui button icon-button"><?= instant_mix_icon ?> Фильтры </a>

</div>

<div class="tab-contents">
    <section class="tab-content active-tab" data-tab="1">
        <? foreach ($books_progress as $book) {
            echo PanelBookDisplay::widget(['data' => $book]);
        }?>
    </section>
    <section class="tab-content" data-tab="2">
        <? foreach ($books_complete as $book) {
            echo PanelBookDisplay::widget(['data' => $book]);
        }?>
    </section>
    <section class="tab-content" data-tab="3">
        <? foreach ($books_frozen as $book) {
            echo PanelBookDisplay::widget(['data' => $book]);
        }?>
    </section>
    <section class="tab-content" data-tab="4">
        <? foreach ($books_draft as $book) {
            echo PanelBookDisplay::widget(['data' => $book]);
        }?>
    </section>
    <section class="tab-content" data-tab="5">
        <? foreach ($books_process as $book) {
            echo PanelBookDisplay::widget(['data' => $book]);
        }?>
    </section>
</div>


