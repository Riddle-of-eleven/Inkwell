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
    
    const confirm = $('#delete-book-confirm')[0];
    $('#delete-existing-book').click(function () {
        confirm.showModal();
    });
    $('.close-button').click(function () {
        confirm.close();
    });
    $('#reject-delete').click(function () {
        confirm.close();
    });
    $('#accept-delete').click(function () {
        $.ajax('http://inkwell/web/author/modify/delete-book');
    });
JS);


?>

<dialog class="block modal" id="delete-book-confirm">
    <div class="close-button"><?=close_icon?></div>
    <div class="modal-container" id="delete-modal">
        <div class="header3">Вы точно хотите удалить книгу?</div>
        <div class="tip-color">Это действие переместит книгу "<?=$book->title?>" в корзину, где она будет храниться 30 дней, после чего будет удалена навсегда без возможности восстановления.</div>
        <div class="modal-buttons">
            <div class="ui button button-center-align" id="reject-delete">Нет, оставьте</div>
            <div class="ui button button-center-align danger-accent-button" id="accept-delete">Да, удалите</div>
        </div>
    </div>
</dialog>

<div class="dashboard-header functional-header">
    <div>
        <h1 class="header1">Редактирование книги "<?=$book->title?>"</h1>
    </div>
    <div class="dashboard-actions">
        <div class="dashboard-main-actions">
            <!--<div class="ui button icon-button"><?= save_icon ?>Сохранить изменения</div>
            <div class="vertical-line"></div>-->
            <?=Html::a(new_chapter_icon . 'Добавить часть', Url::to(['author/modify/add-chapter']), ['class' => 'ui button icon-button'])?>

            <? $preview_class = $book->is_draft ? ' disabled-button' : ''; ?>
            <?=Html::a(file_open_icon . 'Посмотреть книгу', Url::to(['main/book', 'id' => $book->id]), [
                'class' => 'ui button icon-button' . $preview_class,
                'id' => 'preview-book'
            ])?>
        </div>
        <?= Html::button(new_book_icon . 'Удалить книгу', ['class' => 'ui button icon-button danger-accent-button', 'id' => 'delete-existing-book']) ?>
    </div>
</div>


<div class="tab-header">

    <div class="tab" data-tab="main"><?=description_icon?>Общая информация</div>
    <div class="tab" data-tab="chapters"><?=library_books_icon?>Части</div>
    <div class="tab" data-tab="access"><?=eye_tracking_icon?>Доступ, видимость и статус</div>
    <!--<div class="tab" data-tab="statistics"><?= bar_chart_icon ?>Статистика</div>
    <div class="tab" data-tab="5"><?= branch_icon ?>Версии и изменения</div>
    <div class="tab" data-tab="6"><?= deployed_code_icon ?>Проект</div>-->
</div>

<section class="tab-contents dashboard-tab"><div>
