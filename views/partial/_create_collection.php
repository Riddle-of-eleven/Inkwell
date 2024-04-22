<?php
/* @var $model */
/* @var $book_id */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="header3">Создать новую подборку</div>
<? $f = ActiveForm::begin(['method' => 'post', 'id' => 'form-create-collection', 'options' => ['class' => 'new-collection']]); ?>

<div class="">
    <?= $f->field($model, 'title', [
        'options' => ['class' => 'ui field field-with-hint'],
        'inputOptions' => ['class' => ''],
        'template' => "{input}\n{hint}{error}",
    ])->textInput(['autofocus' => true, 'placeholder' => 'Название подборки'])->label(false)
        ->hint('Не менее 8 символов'); ?>

    <?= $f->field($model, 'book_id')->hiddenInput(['value'=> $book_id])->label(false)?>

    <?= $f->field($model, 'is_private', [
        'options' => ['tag' => false],
        'template' => '{input}',
    ])->checkbox(['id' => 'is_private', 'label' => false]) ?>
    <label for="is_private">Сделать подборку приватной</label>
</div>

<?= Html::submitButton(list_alt_icon . 'Создать подборку', ['class' => 'ui button icon-button', 'name' => 'create-collection-submit']) ?>

<? ActiveForm::end() ?>