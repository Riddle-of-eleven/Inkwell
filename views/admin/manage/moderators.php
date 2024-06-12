<?php
$this->title = 'Модераторы';

/** @var $this View */
/* @var $users User[]*/
/* @var $admin User */
/* @var $pages */

use app\models\Tables\User;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');
$this->registerJs(<<<js
      $('.make-moderator').on('click', function() {
            let id = $(this).closest('.block').attr('data-id');
            let button = $(this);
            $.ajax({
                type: 'post',
                url: 'http://inkwell/web/admin/manage/manage-moderator',
                data: {id: id},
                success: function (response) {
                    if (response.success) {
                        markButton(response.is_moderator, button, 'filled-button');
                        if (response.is_moderator) button.find('.button-text').text('Убрать из модераторов');
                        else button.find('.button-text').text('Сделать модератором');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
      });
js);

$linkPager = LinkPager::widget(['pagination' => $pages]);

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Модераторы</div>
        <div class="tip-color">Здесь можно пользователей, которых вы хотите видеть в качестве модераторов.</div>
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

            <? if ($user->id == $admin->id) : echo '<div class="tip-color">Это вы и вы администратор</div>';
                else :
                    if ($user->is_moderator == 1) {
                        $class = 'filled-button';
                        $text = 'Убрать из модераторов';
                    }
                    else {
                        $class = '';
                        $text = 'Сделать модератором';
                    } ?>
                    <div class="ui button icon-button <?=$class?> make-moderator">
                        <?=shield_person_icon?>
                        <div class="button-text"><?=$text?></div>
                    </div>
                <? endif; ?>
        </div>
    <? endforeach;
    echo $linkPager; ?>
<? endif;