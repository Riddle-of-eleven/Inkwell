<?php
$this->title = 'Подписки';

/* @var $follows */

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile("@web/css/parts/user/author.css");

?>

<div>
    <div class="header1">Подписки</div>
    <div class="tip-color">Здесь показаны все авторы, на которых вы подписались</div>
</div>

<? if ($follows)
    foreach ($follows as $follow) { ?>
    <div class="followed-author block">
        <div>
            <div class="small-profile-picture"><?=Html::img('@web/'.$follow->avatar)?></div>
            <?= Html::a($follow->login, Url::to(['main/author', 'id' => $follow->id]), ['class' => 'profile-name header3']) ?>
        </div>
    </div>
<? }?>