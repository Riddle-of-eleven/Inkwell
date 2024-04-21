<?php
$this->title = 'Добавление фэндома';

/* @var $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\app\assets\DashboardAsset::register($this);
$this->registerCss(<<<css
    form {
        margin-top: 20px;
    }
css);

?>

<div class="header1">Добавление фэндома</div>
<div class="head-article">
    Перед созданием фэндома убедитесь, что не нарушаете <?= Html::a('правила публикации', Url::to(['']), ['class' => 'highlight-link']) ?>.
</div>


<? $f = ActiveForm::begin([
    'method' => 'post',
    'id' => 'form-fandom',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
]) ?>

    <div class="header3">Название фэндома</div>
<?= $f->field($model, 'title', [
    'options' => ['class' => 'ui field field-with-hint'],
    'inputOptions' => ['class' => ''],
    'template' => "{input}\n{hint}{error}",
])->textInput(['autofocus' => true, 'placeholder' => 'Как называется ваш фэндом?'])->label(false);?>

    <div class="header3">Описание</div>
<?= $f->field($model, 'description')->textarea(['rows' => '6', 'placeholder' => 'Вкратце расскажите о вашем фэндоме']) ?>

<?= Html::submitButton('Добавить', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>