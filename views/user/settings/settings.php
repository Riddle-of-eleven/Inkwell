<?php
$this->title = 'Настройки профиля';

/* @var yii\web\View $this*/
/* @var $tab */
/* @var User $user */

use app\models\Tables\User;
use yii\web\View;

\app\assets\DashboardAsset::register($this);
\app\assets\SettingsAsset::register($this);
\app\assets\SettingsCropperAsset::register($this);

$this->registerJs(<<<js
    $(document).ready(function() {
        loadTab('user/settings', '$tab', $('.tab-contents'));
        $('[data-tab=$tab').addClass('active-tab');
    });
js, View::POS_LOAD);

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Настройки</div>
        <div class="tip-color">Здесь вы можете изменять параметры профиля, а также управлять предпочтениями.</div>
    </div>
</div>

<div class="tab-header">
    <div class="tab" data-tab="user-settings"><?=manage_accounts_icon?> Настройки профиля</div>
    <div class="tab" data-tab="blacklist"><?=block_icon?> Чёрный список</div>

    <? if ($user->is_publisher == 1) :?>
        <div class="tab" data-tab="publisher"><?=apartment_icon?> Для издательств</div>
    <? endif; ?>

    <div class="tab" data-tab="actions"><?=warning_icon?> Действия</div>
</div>

<section class="tab-contents"></section>