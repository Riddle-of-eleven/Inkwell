<?php
$this->title = Yii::$app->name.' – жанры и теги';

/* @var $genres */
/* @var $tags */

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');
$this->registerCssFile('@web/css/dashboards/tag.css');

?>

<div class="dashboard-header">
    <div>
        <h1>Жанры и теги</h1>
        <div class="tip-color">На этой странице отображаются жанры и теги, добавленные вами</div>
    </div>
    <?= Html::a(new_tag_icon . 'Добавить жанр или тег', Url::to(['moderator/moderator-panel/choose-type']), ['class' => 'ui button icon-button accent-button']) ?>
</div>



<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><div class="tab-number"><?=count($genres)?></div>Жанры</div>
    <div class="tab" data-tab="2"><div class="tab-number"><?=count($tags)?></div>Теги</div>
</div>

<div class="tab-contents">
    <section class="tags-tab tab-content active-tab" data-tab="1">
        <? foreach ($genres as $genre) { ?>
            <div class="tag-block block">
                <div class="tag-inner">
                    <div class="tag-title"><?=$genre->title?></div>
                    <div class="tag-created-at tip"><?=$genre->created_at?></div>
                </div>
                <div class="ui button small-button danger-accent-button"><?=delete_icon?></div>
            </div>
        <? } ?>


    </section>
    <section class="tags-tab tab-content" data-tab="2">
        <? foreach ($tags as $tag) { ?>
            <div class="tag-block block">
                <div class="tag-inner">
                    <div class="tag-title"><?=$tag->title?></div>
                    <div class="tag-created-at tip"><?=$tag->created_at?></div>
                </div>
                <div class="ui button small-button danger-accent-button"><?=delete_icon?></div>
            </div>
        <? } ?>
    </section>
</div>