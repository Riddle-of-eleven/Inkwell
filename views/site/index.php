<?php
$this->title = 'Главная';

/** @var yii\web\View $this */
/** @var $books Book */
/* @var $pages */


use app\models\Tables\Book;
use app\widgets\BookDisplay;
use yii\widgets\LinkPager;

?>

<!--<div class="center-container">
    <div class="main-epigraph">Inkwell – Истории, которые ещё предстоит написать</div>
</div>-->

<? if ($books) foreach ($books as $book) echo BookDisplay::widget(['book' => $book]);


echo LinkPager::widget(['pagination' => $pages]);