<?php
$this->title = 'Новая книга – фэндомные сведения';

/** @var yii\web\View $this */

/* @var FormCreateFandom $model */
/* @var Fandom[] $model_fandoms */
/* @var $model */
/* @var $types */


use app\models\CreateBookForms\FormCreateFandom;
use app\models\Tables\Fandom;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

\app\assets\DashboardAsset::register($this);
$this->registerCss(<<<css
    form {
        display: flex; flex-direction: column; gap: 40px;
    }
    .fandom-section {
        display: flex; flex-direction: column; gap: 20px;
    }
    .fandoms {
        display: flex; flex-direction: column; gap: 10px;
    }
    .character-dropdown {
        display: flex; flex-direction: row; gap: 10px;
    }
    #selected-fandoms {
        display: flex; flex-direction: column; gap: 4px;
    }
    .fandoms-and-origins {
        display: flex; flex-direction: column; gap: 8px;
    }
    .fandoms-and-origins .field-header-words {
        margin: 0;
    }
css);
$this->registerJsFile('@web/js/author/fandoms-handler.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?=Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link'])?>.<br>
    Также вы можете почитать о <?=Html::a('правилах хорошего тона', Url::to(['']), ['class' => 'highlight-link'])?> (где рассказывается про оформление книг и не только),
    а также найти жанр и тег по вкусу в <?=Html::a('списке', Url::to(['']), ['class' => 'highlight-link'])?>.
</div>


<div class="steps">
    <div class="step completed-step"><?=check_circle_icon?> 1. Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step active-step"><?=fire_icon?> 2. Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step"><?=imagesmode_icon?> 3. Обложка</div>
    <?=chevron_right_icon?>
    <div class="step"><?=person_icon?> 4. Доступ</div>
</div>




<? $f = ActiveForm::begin([
    'method' => 'post',
    'id' => 'form-fandom',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => ''],
]) ?>

<section>
    <div class="header2">Фэндомные сведения</div>

    <div>
        <div class="header3">Тип книги</div>
        <?= $f->field($model, 'type')->radioList($types, [
            'item' => function($index, $label, $name, $checked, $value) {
                return "<div class='ui choice-input-block'><input type='radio' name='$name' id='type-$value' value='$value'><label for='type-$value'>$label</label></div>";
            }, 'class' => 'dashboard-choice', 'id' => 'type-radio']);
        ?>
    </div>

    <div class="fandom-section hidden">
        <div class="fandoms-and-origins">
            <div class="field-header-words">
                <div class="header3">Фэндомы</div>
                <!--<div class="symbol-count">0 / 10</div>-->
            </div>
            <div class="field-with-dropdown">
                <div class="ui field"><?=Html::textInput('fandoms-input', null, [
                        'id' => 'fandoms-input',
                        'placeholder' => 'Введите первые несколько символов...',
                        'autocomplete' => 'off'
                    ])?></div>
                <div class="dropdown-list block hidden" id="fandoms-select"></div>
            </div>
            <div id="selected-fandoms"></div>
        </div>

        <div>
            <div class="field-header-words">
                <div class="header3">Персонажи</div>
                <!--<div class="symbol-count">0 / 10</div>-->
            </div>
            <div class="selected-items" id="characters-selected-items"></div>
            <div class="field-with-dropdown characters-container">
                <div class="tip-color fandom-first">Сначала выберите фэндом</div>
            </div>
        </div>

        <div>
            <div class="header3">Пейринги</div>
            <div class="pairing-container">
                <div class="tip-color fandom-first">Сначала выберите фэндом</div>
            </div>
        </div>

    </div>

</section>

<?= Html::submitButton('Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>