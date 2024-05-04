<?php
$this->title = 'Добавление книги';

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

use yii\helpers\VarDumper;

\app\assets\BookCreateAsset::register($this);

?>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?=Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link'])?>.<br>
    Также вы можете почитать о <?=Html::a('правилах хорошего тона', Url::to(['']), ['class' => 'highlight-link'])?> (где рассказывается про оформление книг и не только),
    а также найти жанр и тег по вкусу в <?=Html::a('списке', Url::to(['']), ['class' => 'highlight-link'])?>.
</div>

<div class="steps">
    <div class="step active-step" data-step="1_main"><?=save_icon?> Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="2_fandom"><?=fire_icon?> 2. Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="3_cover"><?=imagesmode_icon?> 3. Обложка</div>
    <?=chevron_right_icon?>
    <div class="step completed-step" data-step="4_access"><?=person_icon?> 4. Доступ</div>
</div>

<div class="line"></div>

<section class="step-content"></section>