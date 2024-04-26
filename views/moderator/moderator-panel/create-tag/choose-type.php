<?php
$this->title = 'Выбор типа метки';

/* @var $model */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);

?>

<div class="header1">Добавление метки</div>
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
    <div class="field-header-words"><div class="header3">Выберите тип создаваемой метки</div><!--<div class="symbol-count">0 / 100</div>--></div>
        <?= $f->field($model, 'type')->radioList([1 => 'Жанр', 2 => 'Тег'], [
            'item' => function($index, $label, $name, $checked, $value) {
                return "<div class='ui choice-input-block'>
                            <input type='radio' name='$name' id='type-$value' value='$value'>
                            <label for='type-$value'>$label</label>
                        </div>";
            }, 'class' => 'dashboard-choice', 'id' => 'type-radio']);
        ?>

    <div class="tip-color">Разница между тегом и жанром заключается в том, что жанр описывает общие направления литературы и такие понятия, которые определяют книгу целиком. Теги помечают отдельные её моменты, сообщают читателю о том, что он может встретить на страницах книги.</div>
</section>

<?= Html::submitButton('Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>