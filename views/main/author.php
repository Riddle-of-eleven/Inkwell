<?php
/* @var User $user */
/* @var $books */
/* @var $follow */
$this->title = 'Профиль автора '.$user->login;

use app\models\User;
use yii\helpers\Html;
use app\widgets\BookDisplay;

$this->registerCssFile("@web/css/parts/user/author.css");
$this->registerJsFile('@web/js/ajax/interaction.js', ['depends' => [\yii\web\JqueryAsset::class]]);


if (!Yii::$app->user->isGuest) {
    $follow_class = $follow ? 'filled-button' : '';
    $follow_text = $follow ? 'Отписаться' : 'Подписаться';
}


?>

<div class="profile-header">
    <div class="block author-header">
        <div class="profile-picture"><?=Html::img('@web/'.$user->avatar)?></div>
        <div class="profile-info">
            <div class="profile-name header2"><?=$user->login?></div>
            <!--<div class="profile-online-status tip">Был в сети 2 часа назад</div>-->
        </div>
    </div>

    <? if (!Yii::$app->user->isGuest) :?>
    <div class="author-actions">
        <div class="">
            <button class="ui button button-left-align <?=@$follow_class?>" id="follow-interaction"><?=favorite_icon?><div class="button-text"><?=$follow_text?></div></button>
            <!--<a href="" class="ui button icon-button"><?=mail_icon?>Написать</a>
            <a href="" class="ui button icon-button"><?=person_add_icon ?>Пригласить</a>-->
        </div>
        <div class="">
            <a href="" class="ui button small-button danger-button"><?=block_icon?></a>
            <a href="" class="ui button small-button danger-button"><?=flag_icon?></a>
        </div>
    </div>
    <? endif; ?>
</div>


<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><?=cognition_icon?>Об авторе</div>
    <div class="tab" data-tab="2"><?=library_books_icon?>Книги</div>
    <div class="tab" data-tab="3"><?=list_alt_icon?>Подборки</div>
</div>

<div class="tab-contents">
    <section class="tags-tab tab-content active-tab" data-tab="1">
        <div class="block author-about">
            <div class="about-title">О себе</div>
            <div class="about-text"><?=$user->about?></div>

            <!--<div class="about-title">Контактная информация</div>
            <div class="about-text">Подписывайтесь на меня в соцсетях.</div>-->
        </div>
    </section>

    <section class="tags-tab tab-content" data-tab="2">
        <? if ($books) {
            foreach ($books as $book) {
                echo BookDisplay::widget(['data' => $book]);
           }
        } ?>
    </section>

</div>