<?php
$this->title = Yii::$app->name . ' – новая книга';

/* @var $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\app\assets\DashboardAsset::register($this);


?>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?= Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link']) ?>.
</div>


<div class="steps">
    <div class="step completed-step"><?=check_circle_icon?> 1. Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step completed-step"><?=check_circle_icon?> 2. Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step active-step"><?=imagesmode_icon?> 3. Обложка</div>
    <?=chevron_right_icon?>
    <div class="step"><?=person_icon?> 4. Доступ</div>
</div>




<? $f = ActiveForm::begin([
    'method' => 'post',
    'id' => 'form-cover',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
]) ?>

<?=$f->field($model, 'cover')->fileInput();?>

<?= Html::submitButton('Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>
