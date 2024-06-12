<?php
$this->title = 'Подборки';

/* @var $collections Collection[] */
/* @var $pages */

use app\models\Tables\Collection;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1 class="header1">Подборки</h1>
<div class="head-article">
    Тематические подборки, в которые другие пользователи добавляют книги.
</div>

<div class="inner-line"></div>

<?php

if ($collections) :
    foreach ($collections as $collection) :
        $count = count($collection->books); ?>
        <div class="block user-block">
            <div class="fandoms-item-header">
                <div class="header3"><?=$collection->title?></div>
                <div class="tip-color">x <?=$count?></div>
            </div>
            <div class="tip-color"><?=$collection->description?></div>
        </div>
    <? endforeach; ?>

    <div class="center-container"><?=LinkPager::widget(['pagination' => $pages])?></div>

<? else : ?>
    <div class="tip-color">Кажется, здесь ничего нет</div>

<? endif;
