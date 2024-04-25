<?php
$this->title = 'Добавление главы';

/* @var $model*/

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\app\assets\DashboardAsset::register($this);

?>


<div class="header1">Добавление главы</div>

<div class="head-article">
    Для добавления абзацев используйте 	&lt;tab&gt;. Вы можете создать эту главу <?=Html::a('из файла .docx', Url::to(['create-chapter-file', 'id' => Yii::$app->request->get('id')]), ['class' => 'highlight-link'])?>
</div>


<? $f = ActiveForm::begin([
    'method' => 'post',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
])
?>

<section>
    <div>
        <div class="field-header-words"><div class="header3">Название</div><!--<div class="symbol-count">0 / 100</div>--></div>
        <?= $f->field($model, 'title', [
            'options' => ['class' => 'ui field field-with-hint'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}\n{hint}{error}",
        ])->textInput(['autofocus' => true, 'placeholder' => 'Название главы'])->label(false);?>
    </div>

    <div>
        <div class="field-header-words"><div class="header3">Текст главы</div><!--<div class="symbol-count">0 / 500</div>--></div>
        <?= $f->field($model, 'content')->textarea(['rows' => '18', 'placeholder' => 'Введите текст сюда']) ?>
    </div>
</section>


<?= Html::submitButton('Добавить', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>