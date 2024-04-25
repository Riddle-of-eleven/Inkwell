<?php
$this->title = 'Добавление главы из файла';

/* @var $model*/

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\app\assets\DashboardAsset::register($this);

?>


<div class="header1">Добавление главы из файла</div>
<div class="head-article">
    Конвертация возможно только из .docx и .odt файлов
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

        <?=$f->field($model, 'file')->fileInput();?>
    </section>


<?= Html::submitButton('Добавить', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>