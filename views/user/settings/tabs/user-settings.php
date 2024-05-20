<?php
/** @var View $this */

/* @var FormSystemSettings $system_model */
/* @var FormPublicSettings $public_model */

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use app\models\Forms\User\FormSystemSettings;
use app\models\Forms\User\FormPublicSettings;

?>

<div class="header2">Системные данные</div>
<? $system = ActiveForm::begin([
    'method' => 'post',
    'id' => 'system-data-form',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
]) ?>

<div class="record-item">
    <div class="header3">Имя пользователя</div>
    <?= $system->field($system_model, 'login', [
            'options' => ['class' => 'ui field field-with-hint'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}\n{hint}{error}",
    ])->textInput()->label(false); ?>
</div>


<?= Html::submitButton('Сохранить', ['class' => 'ui button icon-button', 'name' => 'system-data-submit']) ?>
<? ActiveForm::end() ?>


<div class="header2">Публичные сведения</div>

