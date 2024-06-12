<?php
$this->title = 'Фэндомы';

/* @var $fandoms Fandom[] */
/* @var $pages */

use app\models\Tables\Fandom;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1 class="header1">Фэндомы</h1>
<div class="head-article">
    Истории, по которым вы можете написать свои
</div>

<div class="inner-line"></div>

<?php

if ($fandoms) :
    foreach ($fandoms as $fandom) :
        $count = count($fandom->bookFandoms); ?>
        <div class="fandoms-item block">
            <div class="fandoms-item-header">
                <div class="header3"><?=$fandom->title?></div>
                <div class="tip-color">x <?=$count?></div>
            </div>
            <div class="tip-color"><?=$fandom->description?></div>
        </div>
<? endforeach; ?>

<div class="center-container"><?=LinkPager::widget(['pagination' => $pages])?></div>

<? else : ?>
<div class="tip-color">Кажется, здесь ничего нет</div>

<? endif;

