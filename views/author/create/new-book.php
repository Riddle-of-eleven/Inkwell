<?php
$this->title = 'Добавление книги';

/** @var yii\web\View $this */
/* @var $step */
/* @var $allow */

use yii\web\View;

use yii\helpers\Html;
use yii\helpers\Url;

use yii\helpers\VarDumper;

$session = Yii::$app->session;
//VarDumper::dump($session['create.pairings'], 10, true);
//$session->remove('create.relation');

\app\assets\BookCreateAsset::register($this);
\app\assets\BookCreateCropperAsset::register($this);
$this->registerJs(<<<js
    $(document).ready(function() {
        loadStepByName('$step');
        $('[data-step=$step').addClass('active-step');
    });
js, View::POS_LOAD);

$safety_class = $allow ? '' : 'disabled-button';

?>

<dialog class="block modal" id="delete-book-confirm">
    <div class="close-button"><?=close_icon?></div>
    <div class="modal-container" id="delete-modal">
        <div class="header3">Вы точно хотите удалить книгу?</div>
        <div class="tip-color">Это очистит все данные о ней. Данное действие нельзя отменить</div>
        <div class="modal-buttons">
            <div class="ui button button-center-align" id="reject-delete">Нет, оставьте</div>
            <div class="ui button button-center-align danger-accent-button" id="accept-delete">Да, удалите</div>
        </div>
    </div>
</dialog>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?=Html::a('правилами публикации', Url::to(['information/publication_rules']), ['class' => 'highlight-link'])?>.<br>
    Также вы можете почитать о <?=Html::a('правилах хорошего тона', Url::to(['information/behavior']), ['class' => 'highlight-link'])?> (где рассказывается про оформление книг и не только),
    а также найти жанр и тег по вкусу в <?=Html::a('списке', Url::to(['main/tags']), ['class' => 'highlight-link'])?>.
</div>

<div class="steps">
    <div class="step" data-step="main"><?=save_icon?> Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="fandom"><?=fire_icon?> Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="cover"><?=imagesmode_icon?> Обложка</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="access"><?=person_icon?> Доступ</div>
</div>

<!-- есть тут ещё класс completed_step. в целом на завершение шага лучше бы его добавлять и менять иконку на кружочек.
     а если есть ошибки, тогда на восклицательный знак или типа того
-->

<section class="step-content"></section>

<div class="inner-line"></div>

<div class="publish-actions">
    <div class="ui button icon-button danger-accent-button" id="delete-new-book"><?=delete_icon?>Удалить книгу</div>
    <div class="ui button icon-button <?=$safety_class?>" id="save-new-book"><?=library_books_icon?>Завершить и перейти к частям</div>
</div>