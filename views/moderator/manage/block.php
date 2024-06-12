<?php
$this->title = 'Блокировка пользователей';

/** @var $this View */
/* @var $users User[]*/
/* @var $moderator User */
/* @var $pages */

use app\models\Tables\User;
use yii\i18n\Formatter;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');
$this->registerJs(<<<js
      $('.block-this-user').on('click', function() {
            let id = $(this).closest('.block').attr('data-id'),
                button = $(this);
            let until = $('.block[data-id=' + id + '] .ban-until');
            $.ajax({
                type: 'post',
                url: 'http://inkwell/web/moderator/manage/manage-block',
                data: {id: id},
                success: function (response) {
                    if (response.success) {
                        markButton(response.is_banned, button, 'filled-button');
                        if (response.is_banned) {
                            button.find('.button-text').text('Снять блокировку');
                            until.text('Пользователь заблокирован до: ' + response.banned_until)
                            until.removeClass('hidden');
                        }
                        else {
                            button.find('.button-text').text('Заблокировать');
                            until.addClass('hidden');
                        }
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
      });
js);

$formatter = new Formatter();
$linkPager = LinkPager::widget(['pagination' => $pages]);

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Блокировка пользователей</div>
        <div class="tip-color">Здесь вы можете управлять блокировкой пользователей. Будьте внимательны, блокировать пользователей можно, только если они нарушают правила и ведут себя некорректно.</div>
    </div>
</div>

<div class="inner-line"></div>

<div class="header3">Пользователи</div>

<? if ($users) :
    foreach ($users as $user) : ?>
        <div class="block user-block" data-id="<?=$user->id?>">
            <div class="standard-gap">
                <?=Html::a($user->login, Url::to(['main/author', 'id' => $user->id]))?>
                <div class="tip-color">(книги: <?=count($user->books)?>)</div>
            </div>

            <div class="standard-gap">
                <? if ($user->is_banned) echo '<div class="tip-color ban-until">Пользователь заблокирован до: ' . $formatter->asDatetime($user->banned_until, "d MMMM yyyy, HH:mm") . '</div>';
                else echo '<div class="tip-color ban-until hidden"></div>';
                if ($user->id == $moderator->id) : echo '<div class="tip-color">Это вы и вы не можете заблокировать себя (в общем-то, оно вам и не надо)</div>';
                else :
                    if ($user->is_banned == 1) {
                        $class = 'filled-button';
                        $text = 'Снять блокировку';
                    }
                    else {
                        $class = '';
                        $text = 'Заблокировать';
                    } ?>
                    <div class="ui button icon-button <?=$class?> block-this-user">
                        <?=block_icon?>
                        <div class="button-text"><?=$text?></div>
                    </div>
                <? endif; ?>
            </div>
        </div>
    <? endforeach;
    echo $linkPager; ?>
<? endif;