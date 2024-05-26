<?php
$this->title = 'Авторы';

/* @var $authors */
/* @var $pages */

use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1 class="header1">Авторы</h1>
<div class="head-article">
    Здесь перечислены все авторы
</div>

<?php

if ($authors)
    foreach ($authors as $author) { ?>
    <div class="followed-author block">
        <div>
            <div class="small-profile-picture"><?= !$author->avatar ? blank_avatar : Html::img('@web/images/avatar/uploads/' . $author->avatar . '.png') ?></div>
            <?= Html::a($author->login, Url::to(['main/author', 'id' => $author->id]), ['class' => 'profile-name header3']) ?>
        </div>
    </div>
<? }

echo LinkPager::widget(['pagination' => $pages]);