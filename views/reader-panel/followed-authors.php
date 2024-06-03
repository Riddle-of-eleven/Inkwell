<?php
$this->title = 'Подписки';

/* @var $follows User[] */

use app\models\Tables\User;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\AuthorDisplay;

$this->registerCssFile("@web/css/parts/user/author.css");

?>

<div>
    <div class="header1">Подписки</div>
    <div class="tip-color">Здесь показаны все авторы, на которых вы подписались</div>
</div>


<section class="user-list">
    <? if ($follows)
        foreach ($follows as $follow) {
            echo AuthorDisplay::widget(['author' => $follow]);
        }
    else echo '<div class="center-container tip-color">Ничего не найдено</div>';

    //echo LinkPager::widget(['pagination' => $pages]);
    ?>

</section>