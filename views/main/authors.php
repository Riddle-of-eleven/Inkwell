<?php
$this->title = 'Авторы';

/* @var $authors User[] */
/* @var $pages */

use app\models\Tables\User;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\AuthorDisplay;

?>

<h1 class="header1">Авторы</h1>
<div class="head-article">
    Здесь перечислены все авторы
</div>

<div class="inner-line"></div>


<section class="user-list">
    <? if ($authors)
        foreach ($authors as $author) {
            echo AuthorDisplay::widget(['author' => $author]);
        }
    else echo '<div class="center-container tip-color">Ничего не найдено</div>';

    echo LinkPager::widget(['pagination' => $pages]); ?>

</section>