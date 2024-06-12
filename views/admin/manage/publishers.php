<?php
$this->title = 'Издательства';

/** @var $this View */
/* @var $users User[] */
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
      $('.make-publisher').on('click', function() {
            let id = $(this).closest('.block').attr('data-id');
            let button = $(this);
            $.ajax({
                type: 'post',
                url: 'http://inkwell/web/admin/manage/manage-publisher',
                data: {id: id},
                success: function (response) {
                    if (response.success) {
                        markButton(response.is_publisher, button, 'filled-button');
                        if (response.is_publisher) button.find('.button-text').text('Убрать из издательств');
                        else button.find('.button-text').text('Пометить как издательство');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
      });
js
);

$linkPager = LinkPager::widget(['pagination' => $pages]);

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Издательства</div>
        <div class="tip-color">Здесь вы можете добавить издательство.</div>
    </div>
</div>

<div class="inner-line"></div>

<div class="header3">Пользователи</div>

<? if ($users) :
    foreach ($users as $user) : ?>
        <div class="block user-block" data-id="<?= $user->id ?>">
            <div class="standard-gap">
                <?= Html::a($user->login, Url::to(['main/author', 'id' => $user->id])) ?>
                <div class="tip-color">(книги: <?= count($user->books) ?>)</div>
            </div>

            <? if ($user->id == $admin->id) : echo '<div class="tip-color">Это вы и вы вряд ли издательство</div>';
            else :
                if ($user->is_publisher == 1) {
                    $class = 'filled-button';
                    $text = 'Убрать из издательств';
                } else {
                    $class = '';
                    $text = 'Пометить как издательство';
                } ?>
                <div class="ui button icon-button <?= $class ?> make-publisher">
                    <?= apartment_icon ?>
                    <div class="button-text"><?= $text ?></div>
                </div>
            <? endif; ?>
        </div>
    <? endforeach;
    echo $linkPager; ?>
<? endif;