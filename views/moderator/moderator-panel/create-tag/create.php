<?php
/* @var $model */
/* @var $type */
/* @var $types */
/* @var $type_name */
$this->title = 'Добавление '.$type_name.'а';

//use Yii;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

\app\assets\DashboardAsset::register($this);
$this->registerCss(<<<css
    form {
        display: flex; flex-direction: column; gap: 40px;
    }
css);

?>

<div class="header1">Добавление <?=$type_name?>а</div>
<div class="head-article tip-color">
    Помните о том, что жанры и теги должны быть полезными. В <a href="" class="highlight-link">некоторых случаях</a> администратор может удалить то, что вы добавите.
</div>


<div class="steps">
    <div class="step completed-step"><?=check_circle_icon?> 1. Выбор типа метки</div>
    <?=chevron_right_icon?>
    <div class="step active-step"><?=assignment_icon?> 2. Добавление информации</div>
</div>

<? $f = ActiveForm::begin([
    'method' => 'post',
    'fieldConfig' => ['template' => "{input}\n{error}"],
    'options' => ['class' => ''],
]) ?>


    <div>
        <div class="field-header-words"><div class="header3">Название</div><!--<div class="symbol-count">0 / 500</div>--></div>
        <?= $f->field($model, 'title', [
            'options' => ['class' => 'ui field field-with-hint'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}\n{hint}{error}",
        ])->textInput(['autofocus' => true, 'placeholder' => 'Введите название '.$type_name.'а'])->label(false);?>
    </div>

    <div>
        <div class="field-header-words"><div class="header3">Описание</div><!--<div class="symbol-count">0 / 500</div>--></div>
        <?= $f->field($model, 'description')->textarea(['rows' => '4', 'placeholder' => 'Кратко опишите '.$type_name]) ?>
    </div>

    <div>
        <div class="header3">Выберите категорию <?=$type_name?>а</div>
        <?= $f->field($model, 'type')->radioList($types, [
            'item' => function($index, $label, $name, $checked, $value) {
                return "<div class='ui choice-input-block'>
                            <input type='radio' name='$name' id='type-$value' value='$value'>
                            <label for='type-$value'>$label</label>
                        </div>";
            }, 'class' => 'dashboard-choice', 'id' => 'type-radio']);
        ?>
    </div>

    <? if ($type == 1) ?>


<?= Html::submitButton('Добавить '.$type_name, ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>