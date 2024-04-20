<?php
$this->title = Yii::$app->name.' – новая книга';

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?= Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link']) ?>.
</div>


<!--
<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><div class="tab-number">4</div>В процессе</div>
    <div class="tab" data-tab="2"><div class="tab-number">12</div>Завершённые</div>
    <div class="tab" data-tab="3"><div class="tab-number">2</div>Замороженные</div>
    <div class="tab" data-tab="4"><div class="tab-number">36</div>Черновики</div>
</div>

<div class="tab-contents">
    <section class="tab-content active-tab" data-tab="1">
        ryjj
    </section>
    <section class="tab-content" data-tab="2">
        rthrht
    </section>
    <section class="tab-content" data-tab="3">
        thrhrth
    </section>
    <section class="tab-content" data-tab="4">
        trhhtr
    </section>
</div>
-->

<div class="steps">
    <div class="step active-step"><?=save_icon?> 1. Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step"><?=fire_icon?> 2. Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step"><?=imagesmode_icon?> 3. Обложка</div>
    <?=chevron_right_icon?>
    <div class="step"><?=person_icon?> 4. Доступ</div>
</div>


<section>
    <div class="head-article">
        <?= Html::a('Как грамотно оформить шапку книги?', ['']) ?>
    </div>
    <div class="header2">Основное</div>
    <div>
        <div class="field-header-words">
            <div class="header3">Название</div>
            <div class="symbol-count">0 / 100</div>
        </div>
        <div class="ui field">Чёрные птицы</div>
    </div>

    <div>
        <div class="field-header-words">
            <div class="header3">Описание</div>
            <div class="symbol-count">0 / 500</div>
        </div>
        <textarea></textarea>
    </div>

    <div>
        <div class="field-header-words">
            <div class="header3">Примечания</div>
            <div class="symbol-count">0 / 1000</div>
        </div>
        <textarea></textarea>
    </div>


    <div>
        <div class="field-header-words">
            <div class="header3">Дисклеймер</div>
            <div class="symbol-count">0 / 300</div>
        </div>
        <textarea></textarea>
    </div>


    <div>
        <div class="field-header-words">
            <div class="header3">Посвящение</div>
            <div class="symbol-count">0 / 300</div>
        </div>
        <textarea></textarea>
    </div>
</section>