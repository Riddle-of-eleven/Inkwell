<?php
/* @var User $user */
/* @var Book[] $books */
/* @var $follow */
$this->title = 'Профиль автора '.$user->login;

use app\models\Tables\Book;
use app\models\Tables\User;
use app\widgets\BookDisplay;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile("@web/css/parts/user/author.css");
$this->registerJsFile('@web/js/ajax/interaction.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$theme = Yii::$app->session->get('theme');

if (!Yii::$app->user->isGuest) {
    $follow_class = $follow ? 'filled-button' : '';
    $follow_text = $follow ? 'Отписаться' : 'Подписаться';
}


?>

<div class="profile-header">
    <div class="block author-header">
        <div class="profile-picture">
            <?= !$user->avatar ? blank_avatar : Html::img('@web/images/avatar/uploads/' . $user->avatar . '.png') ?>
        </div>
        <div class="profile-info">
            <div class="profile-name header2"><?=$user->login?></div>
            <!--<div class="profile-online-status tip">Был в сети 2 часа назад</div>-->
        </div>
    </div>

    <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity != $user) :?>
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
            <? if ($user->about || $user->contact || ($user->is_publisher == 1 && $user->official_website)) :?>
                <? if ($user->about) : ?>
                    <div class="about-title header3">О себе</div>
                    <div class="about-text"><?=$user->about?></div>
                <? endif; ?>

                <? if ($user->contact) : ?>
                    <div class="about-title header3">Контактная информация</div>
                    <div class="about-text"><?=$user->contact?></div>
                <? endif; ?>

                <? if ($user->is_publisher == 1 && $user->official_website) : ?>
                    <div class="about-title header3">Официальный сайт</div>
                    <div class="about-text"><?=Html::a($user->official_website, Url::to($user->official_website), ['class' => 'highlight-link'])?></div>
                <? endif; ?>
            <? else: ?>
                <div class="tip-color">Автор предпочёл не рассказывать о себе.</div>
            <? endif; ?>
        </div>
    </section>

    <section class="tags-tab tab-content" data-tab="2">
        <? if ($books) {
            foreach ($books as $book) {
                echo BookDisplay::widget(['book' => $book]);
           }
        } ?>
    </section>

</div>