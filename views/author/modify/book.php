<?php
$this->title = 'Редактирование книги';

/* @var yii\web\View $this*/

/* @var $tab */
/* @var $book Book */

use app\models\Tables\Book;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);
$this->registerJs(<<<JS
    $(document).ready(function() {
        loadTab('author/modify', '$tab', $('.tab-contents'));
        $('[data-tab=$tab').addClass('active-tab');
    });
JS);
$this->registerJs(<<<JS
    $('.tab').click(function () {
        loadTab('author/modify', $(this).data('tab'), $('.tab-contents'));
    });
JS);


?>

<div class="dashboard-header functional-header">
    <div>
        <h1 class="header1">Редактирование книги "<?=$book->title?>"</h1>
    </div>
    <div class="dashboard-actions">
        <div class="dashboard-main-actions">
            <div class="ui button icon-button"><?= save_icon ?>Сохранить изменения</div>
            <div class="vertical-line"></div>
            <div class="ui button icon-button"><?= new_chapter_icon ?>Добавить часть</div>
            <div class="ui button icon-button"><?= file_open_icon ?>Посмотреть книгу</div>
        </div>
        <?= Html::a(new_book_icon . 'Удалить книгу', Url::to(['']), ['class' => 'ui button icon-button danger-accent-button']) ?>
    </div>
</div>


<div class="tab-header">
    <div class="tab" data-tab="main"><?= description_icon ?>Общая информация</div>
    <div class="tab" data-tab="chapters"><?= library_books_icon ?>Части</div>
    <div class="tab" data-tab="access"><?= group_icon ?>Доступ</div>
    <div class="tab" data-tab="statistics"><?= bar_chart_icon ?>Статистика</div>
    <!--<div class="tab" data-tab="5"><?= branch_icon ?>Версии и изменения</div>
    <div class="tab" data-tab="6"><?= deployed_code_icon ?>Проект</div>-->
</div>

<section class="tab-contents dashboard-tab"><div>
