<?php
$this->title = 'Выбор типа метки';

/* @var $model */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);

?>

<div class="header1">Добавление жанра или тега</div>
<div class="head-article tip-color">
    Помните о том, что жанры и теги должны быть полезными. В <a href="" class="highlight-link">некоторых случаях</a> администратор может удалить то, что вы добавите.
</div>


<div class="steps">
    <div class="step active-step"><?=tag_icon?> 1. Выбор типа метки</div>
    <?=chevron_right_icon?>
    <div class="step"><?=assignment_icon?> 2. Добавление информации</div>
</div>

<? $f = ActiveForm::begin([
    'method' => 'post',
    'fieldConfig' => ['template' => "{input}\n{error}"],
    'options' => ['class' => ''],
]) ?>

<section>
    <div class="header3">Выбор типа</div>
    <div class="head-article">
        Разница между тегом и жанром заключается в том, что жанр описывает общие направления литературы и такие понятия, которые определяют книгу целиком. Теги помечают отдельные её моменты, сообщают читателю о том, что он может встретить на страницах книги.
    </div>

        <?= $f->field($model, 'type')->radioList([1 => 'Жанр', 2 => 'Тег'], [
            'item' => function($index, $label, $name, $checked, $value) {
                return "<label class='ui choice-input-block'>
                            <input type='radio' name='$name' id='type-$value' value='$value'>
                            <span>$label</span>
                        </label>";
            }, 'class' => 'dashboard-choice', 'id' => 'type-radio']);
        ?>

    <div class="inner-line"></div>

</section>

<?= Html::submitButton(skip_next_icon . 'Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>