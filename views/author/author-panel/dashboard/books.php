<?php
$this->title = 'Книги';

/* @var yii\web\View $this*/

/* @var $tab */

/* @var $progress */
/* @var $complete */
/* @var $frozen */
/* @var $draft */


use app\widgets\BookDisplay;
use yii\i18n\Formatter;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\widgets\PanelBookDisplay;
use app\models\_BookData;

/*$this->params['breadcrumbs'][] = ['label' => 'Кабинет автора'];
$this->params['breadcrumbs'][] = 'Книги';*/

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');

$this->registerJs(<<<js
    $(document).ready(function() {
        loadTab('author/author-panel', '$tab', $('.tab-contents'));
        $('[data-tab=$tab').addClass('active-tab');
    });
js, View::POS_LOAD);

$this->registerJs(<<<js
    $('.tab').click(function () {
        loadTab('author/author-panel', $(this).data('tab'), $('.tab-contents'));
    });
js);

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Книги</div>
        <div class="tip-color">На этой странице отображаются все книги, автором которых вы являетесь.</div>
    </div>
    <?= Html::a(new_book_icon . 'Добавить книгу', Url::to(['author/create-book/create-main']), ['class' => 'ui button icon-button accent-button']) ?>
</div>



<div class="tab-header">
    <div class="tab" data-tab="progress"><div class="tab-number"><?=$progress?></div>В процессе</div>
    <div class="tab" data-tab="complete"><div class="tab-number"><?=$complete?></div>Завершённые</div>
    <div class="tab" data-tab="frozen"><div class="tab-number"><?=$frozen?></div>Замороженные</div>
    <div class="tab" data-tab="draft"><div class="tab-number"><?=$draft?></div>Черновики</div>
</div>

<div class="dashboard-search">
    <div class="ui search-field"><?= search_icon ?><input type="text" placeholder="Поиск"></div>
    <a href="" class="ui button icon-button"><?= instant_mix_icon ?> Фильтры </a>

</div>

<section class="tab-contents"></section>


