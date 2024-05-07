<?php
$this->title = 'Добавление книги';

/** @var yii\web\View $this */
/* @var $step */

use yii\web\View;

use yii\helpers\Html;
use yii\helpers\Url;

use yii\helpers\VarDumper;

/*$session = Yii::$app->session;
VarDumper::dump($session['create.tags'], 10, true);
$session->remove('create.genres');*/

\app\assets\BookCreateAsset::register($this);
$this->registerJs(<<<js
    $(document).ready(function() {
        loadStepByName('$step');
        $('[data-step=$step').addClass('active-step');
    });
js, View::POS_LOAD);

?>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?=Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link'])?>.<br>
    Также вы можете почитать о <?=Html::a('правилах хорошего тона', Url::to(['']), ['class' => 'highlight-link'])?> (где рассказывается про оформление книг и не только),
    а также найти жанр и тег по вкусу в <?=Html::a('списке', Url::to(['']), ['class' => 'highlight-link'])?>.
</div>

<div class="steps">
    <div class="step" data-step="main"><?=save_icon?> Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="fandom"><?=fire_icon?> Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="cover"><?=imagesmode_icon?> Обложка</div>
    <?=chevron_right_icon?>
    <div class="step" data-step="access"><?=person_icon?> Доступ</div>
</div>

<!-- есть тут ещё класс completed_step. в целом на завершение шага лучше бы его добавлять и менять иконку на кружочек.
     а если есть ошибки, тогда на восклицательный знак или типа того
-->

<section class="step-content"></section>