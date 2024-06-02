<?php

/* @var $this View */
/* @var $author User */

use app\models\Tables\User;
use app\models\Tables\Followers;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$book_count = count($author->books);

$follower_count = count($author->followers);
$followed_count = count($author->followers0);

?>


<div class="block user-block">
    <div class="user-block-main">
        <div class="small-profile-picture"><?= !$author->avatar ? blank_avatar : Html::img('@web/images/avatar/uploads/' . $author->avatar . '.png') ?></div>
        <?= Html::a($author->login, Url::to(['main/author', 'id' => $author->id]), ['class' => 'profile-name header3']) ?>
    </div>

    <div class="user-actions">
        <div class="user-statistics">
            <div>Книг: <?=$book_count?></div>
            <div>Подписчиков: <?=$follower_count?></div>
            <div>Подписок: <?=$followed_count?></div>
        </div>
        <? if (!Yii::$app->user->isGuest && $author->id != Yii::$app->user->identity->id) :
            if (Followers::find()->where(['user_id' => $author->id])->andWhere(['follower_id' => Yii::$app->user->identity->id])->one()) : ?>
                <div class="ui button icon-button filled-button"><?=family_star_icon?>Отписаться</div>
            <? else : ?>
                <div class="ui button icon-button"><?=family_star_icon?>Подписаться</div>
            <? endif; ?>
        <? endif; ?>
    </div>
</div>