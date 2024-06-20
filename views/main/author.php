<?php
/* @var User $user */
/* @var Book[] $books */
/* @var $follow */

/* @var BanReason[] $ban_reasons*/

$this->title = 'Профиль автора '.$user->login;

use app\models\Tables\BanReason;
use app\models\Tables\Book;
use app\models\Tables\User;
use app\widgets\BookDisplay;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCssFile("@web/css/parts/user/author.css");
$this->registerCssFile("@web/css/dashboards/steps.css");
$this->registerJsFile('@web/js/ajax/interaction.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$theme = Yii::$app->session->get('theme');

if (!Yii::$app->user->isGuest) {
    $follow_class = $follow ? 'filled-button' : '';
    $follow_text = $follow ? 'Отписаться' : 'Подписаться';
}

?>


<? if ($user->is_banned == 1) : ?>
    <div class='center-container header2' style="margin-top: 200px">Этот пользователь заблокирован</div>
<? else : ?>

<? if (!Yii::$app->user->isGuest) if (Yii::$app->user->identity->is_moderator) : ?>
<dialog class="block modal" id="block-dialog">
    <div class="close-button"><?=close_icon?></div>
    <div class="modal-container" id="regular-modal">
        <div class="header2">Блокировка пользователя "<?=$user->login?>"</div>

        <div class="head-article">Блокируя пользователя, обращайте внимание, что это действие отменяется только по прошествии назначенного времени. Блокируйте пользователей только в случае реального нарушения правил. В случае, если пользователь будет заблокирован просто так, вы можете быть лишены статуса модератора.</div>

        <div class="metadata-item">
            <div class="header3">Причина блокировки</div>
            <? if ($ban_reasons)
                foreach ($ban_reasons as $ban_reason) : ?>
                    <label class="ui choice-input-block">
                        <input type="radio" name="reason" value="<?=$ban_reason->id?>">
                        <span>
                            <div class="title-description">
                                <?=$ban_reason->title?>
                                <div class="tip"><?=$ban_reason->description?></div>
                            </div>
                        </span>
                    </label>
                <? endforeach; ?>
        </div>

        <div class="metadata-item">
            <div class="header3">Время блокировки</div>
            <label class="ui choice-input-block">
                <input type="radio" name="time" value="1">
                <span>Три дня</span>
            </label>
            <label class="ui choice-input-block">
                <input type="radio" name="time" value="2">
                <span>Неделя</span>
            </label>
            <label class="ui choice-input-block">
                <input type="radio" name="time" value="3">
                <span>Месяц</span>
            </label>
            <label class="ui choice-input-block">
                <input type="radio" name="time" value="4">
                <span>Год</span>
            </label>

            <div class="inner-line" style="margin: 10px 0"></div>

            <label class="ui choice-input-block danger-accent">
                <input type="radio" name="time" value="5">
                <span>Навсегда</span>
            </label>
        </div>

        <div class="ui button icon-button danger-accent-button disabled-button" id="ban-user"><?=block_icon?>Заблокировать</div>
    </div>
</dialog>
<? endif; ?>



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

    <? if (!Yii::$app->user->isGuest && Yii::$app->user->identity->id != $user->id) :?>
    <div class="author-actions">
        <div class="">
            <button class="ui button button-left-align <?=@$follow_class?>" id="follow-interaction"><?=favorite_icon?><div class="button-text"><?=$follow_text?></div></button>

            <? if (Yii::$app->user->identity->is_moderator) : ?>
                <div class="ui button button-left-align danger-accent-button" id="block-interaction"><?=block_icon?>Заблокировать</div>
            <? endif; ?>

            <!--<a href="" class="ui button icon-button"><?=mail_icon?>Написать</a>
            <a href="" class="ui button icon-button"><?=person_add_icon ?>Пригласить</a>-->
        </div>
        <!--<div class="">
            <a href="" class="ui button small-button danger-button"><?=block_icon?></a>
            <a href="" class="ui button small-button danger-button"><?=flag_icon?></a>
        </div>-->
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
                <div class="tip-color">Пользователь предпочёл не рассказывать о себе.</div>
            <? endif; ?>
        </div>
    </section>

    <section class="tags-tab tab-content" data-tab="2">
        <? if ($books) : foreach ($books as $book) echo BookDisplay::widget(['book' => $book]);
        else : ?>
            <div class="block author-about">
                <div class="tip-color">Пользователь не опубликовал ни одной книги</div>
            </div>
        <? endif; ?>
    </section>

    <section class="tags-tab tab-content" data-tab="3">
        <? if ($user->collections) :
            foreach ($user->collections as $collection) : ?>
                <div class="block user-block">
                    <div><?=$collection->title?></div>
                    <div class="tip-color"><?=count($collection->books)?></div>
                </div>
            <? endforeach;
            else: ?>
                <div class="block author-about">
                    <div class="tip-color">Пользователь не создал ни одной подборки</div>
                </div>
            <? endif; ?>
    </section>
</div>

<? endif;