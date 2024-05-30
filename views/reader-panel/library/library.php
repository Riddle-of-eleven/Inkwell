<?php
$this->title = Yii::$app->name.' – библиотека';

/* @var $likes Book[] */
/* @var $reads Book[] */
/* @var $laters Book[] */
/* @var $favorites Book[] */
/* @var $tab */

use yii\web\View;
use app\models\Tables\Book;
use yii\helpers\VarDumper;
use app\widgets\BookDisplay;

$this->registerJs(<<<js
    $(document).ready(function() {
        loadTab('reader-panel', '$tab', $('.tab-contents'));
        $('[data-tab=$tab').addClass('active-tab');
    });
js, View::POS_LOAD);
$this->registerJs(<<<JS
    $('.tab').click(function () {
        loadTab('reader-panel', $(this).data('tab'), $('.tab-contents'));
    });
JS);

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Библиотека</div>
        <div class="tip-color">Здесь вы видите ваши любимые книги и фэндомы, а также читательские планы.</div>
    </div>
</div>


<div class="tab-header">
    <div class="tab" data-tab="likes"><?=favorite_icon?>Понравившиеся</div>
    <div class="tab" data-tab="favorites"><?=bookmarks_icon?>Избранные</div>
    <div class="tab" data-tab="reads"><?=priority_icon?>Прочитанные</div>
    <div class="tab" data-tab="laters"><?=hourglass_icon?>Прочитать позже</div>
</div>

<section class="tab-contents"></section>