<?php
$this->title = Yii::$app->name.' – книги';

use yii\i18n\Formatter;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/*$this->params['breadcrumbs'][] = ['label' => 'Кабинет автора'];
$this->params['breadcrumbs'][] = 'Книги';*/

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');

?>

<div class="dashboard-header">
    <div>
        <h1>Книги</h1>
        <div class="tip">На этой странице отображаются все книги, автором которых вы являетесь.</div>
    </div>
    <?= Html::a(new_book_icon . 'Добавить книгу', Url::to(['main/rand-book']), ['class' => 'ui button icon-button accent-button']) ?>
</div>



<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><div class="tab-number">4</div>В процессе</div>
    <div class="tab" data-tab="2"><div class="tab-number">12</div>Завершённые</div>
    <div class="tab" data-tab="3"><div class="tab-number">2</div>Замороженные</div>
    <div class="tab" data-tab="4"><div class="tab-number">36</div>Черновики</div>
</div>

<div class="dashboard-search">
    <div class="ui search-field"><?= search_icon ?><input type="text" placeholder="Поиск"></div>
    <a href="" class="ui button icon-button"><?= instant_mix_icon ?> Фильтры </a>

</div>

<div class="tab-contents">
    <section class="tab-content active-tab" data-tab="1">В процессе</section>
    <section class="tab-content" data-tab="2">Завершённые</section>
    <section class="tab-content" data-tab="3">Замороженные</section>
    <section class="tab-content" data-tab="4">Черновики</section>
</div>


<div class="block book-preview">
    <div class="book-preview-sidebar">
        <div class="side-buttons">
            <?= Html::a(edit_icon, ['author-panel/book'], ['class' => 'ui button very-small-button']) ?>
            <div class="ui button very-small-button"><?= new_chapter_icon ?></div>
            <div class="ui button very-small-button"><?= link_deployed_code_icon ?></div>
            <div class="ui button very-small-button"><?= branch_icon ?></div>
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
                        <div class="creator-name">rjtkjhf</div>
                    </div>
                    <div class="creator">
                        <div class="creator-title">Редакторы:</div>
                        <div class="creator-name">sdtfliy</div>
                    </div>
                </div>
            </div>

            <div class="book-preview-info-cover">
                <div class="book-preview-info">
                    <?= Html::a('Самое красивое название', ['author-panel/book'], ['class' => 'book-preview-title header1']) ?>
                    <div class="info-pairs">
                        <div class="info-pair"><div class="info-key">Количество частей:</div>16</div>
                        <div class="info-pair"><div class="info-key">Последнее обновление:</div>11 апреля 2024</div>
                    </div>
                </div>
                <div class="book-preview-cover">
                </div>
            </div>

            <div class="publication-stats">
                <div class="publication-stat"><?= visibility_icon ?> Просмотры <div>261</div></div>
                <div class="publication-stat"><?= favorite_icon ?> Лайки <div>19</div></div>
                <div class="publication-stat"><?= chat_bubble_icon ?> Комментарии <div>4</div></div>
                <div class="publication-stat"><?= chat_icon ?> Рецензии <div>1</div></div>
                <div class="publication-stat"><?= list_alt_icon ?> Подборки <div>45</div></div>
            </div>
        </div>

        <div class="book-preview-actions">
            <a href="" class="ui button icon-button"><?= expand_more_icon ?>Показать части</a>
            <a href="" class="ui button icon-button"><?= bar_chart_icon ?>Смотреть статистику</a>
            <a href="" class="ui button icon-button"><?= file_open_icon ?>Посмотреть книгу</a>
        </div>

    </div>
    <div class="vertical-line"></div>
    <div class="book-preview-cover-actions">
        <img src="images/covers/cover1.jpg" alt="" class="side-cover">
        <div class="cover-actions">
            <a href="" class="ui button icon-button"><?= imagesmode_icon?>Изменить</a>
            <a href="" class="ui button small-button danger-button"><?= hide_image_icon ?></a>
        </div>
    </div>
</div>