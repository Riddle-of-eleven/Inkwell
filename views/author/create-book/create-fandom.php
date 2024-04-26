<?php
$this->title = Yii::$app->name.' – новая книга';

/* @var $id */
/* @var $model */
/* @var $types */

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
css);

?>


<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?= Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link']) ?>.
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
    <div class="head-article">
        <?= Html::a('В чём разница между фэндомом и первоисточником?', Url::to(['']), ['class' => 'highlight-link']) ?>
    </div>
    <div class="header2">Фэндомные сведения</div>

    <div>
        <div class="header3">Тип книги</div>
        <?= $f->field($model, 'type')->radioList($types, [
            'item' => function($index, $label, $name, $checked, $value) {
                return "<div class='ui choice-input-block'><input type='radio' name='$name' id='type-$value' value='$value'><label for='type-$value'>$label</label></div>";
            }, 'class' => 'dashboard-choice', 'id' => 'type-radio']);
        ?>
    </div>

<? $this->registerJS(<<<'js'
      $('#type-radio input').on('change', function () {
          if ($(this).val() == 2) $('.fandom-section').removeClass('hidden');
          else $('.fandom-section').addClass('hidden');
      });


    $('#fandom-input').click(function () {
        if ($(this).val() == '') {
            $.ajax({
                url: 'index.php?r=author/create-book/find-fandoms',
                type: 'post',
                success: function (response) {
                    if (response) {
                        $('#fandom-select').empty();
                        $.each(response, function(key, value) {
                            $('#fandom-select').append(`<div class="dropdown-item" id="${key}">${value}</div>`);
                        });
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        $('#fandom-select').removeClass('hidden');
    });
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#fandom-select').length && !$(e.target).closest('#fandom-input').length) {
            $('#fandom-select').addClass('hidden');
        }
    });
    
    $('#fandom-select').on('click', '.dropdown-item', function() {
        let id = $(this).attr('id'), title = $(this).html();
        let hidden = $('<input>').attr({
                type: 'hidden',
                name: 'FormCreateFandom[fandoms][]',
                value: id
            });
        
        let fandoms = $('.fandoms');
        fandoms.removeClass('hidden');
        fandoms.append(hidden);
        fandoms.append(`<div class="select-header block" fandom="${id}">
                ${title}
                <div class="ui button small-button danger-accent-button" id="remove-fandom" fandom="${id}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon">
                        <path d="M324.309-164.001q-26.623 0-45.465-18.843-18.843-18.842-18.843-45.465V-696h-48v-51.999H384v-43.384h192v43.384h171.999V-696h-48v467.257q0 27.742-18.65 46.242-18.65 18.5-45.658 18.5H324.309ZM648-696H312v467.691q0 5.385 3.462 8.847 3.462 3.462 8.847 3.462h311.382q4.616 0 8.463-3.846 3.846-3.847 3.846-8.463V-696ZM400.155-288h51.999v-336h-51.999v336Zm107.691 0h51.999v-336h-51.999v336ZM312-696V-216v-480Z"/>
                    </svg>
                </div>
            </div>`);
    });
    
    $('.fandoms').on('click', '#remove-fandom', function() {
        let id = $(this).attr('fandom');
        $(`input[type="hidden"][value="${id}"]`).remove();
        $(`[fandom=${id}]`).remove();
    });
js); ?>

    <div class="fandom-section hidden">
        <div>
            <div class="header3">Фэндомы</div>
            <!--<div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>-->

            <div class="field-with-dropdown">
                <div class="ui field"><?=Html::textInput('fandom-input', null, [
                        'id' => 'fandom-input',
                        'placeholder' => 'Введите первые несколько символов...',
                        'autocomplete' => 'off'
                    ])?></div>
                <div class="dropdown-list block hidden" id="fandom-select"></div>
            </div>
        </div>

        <div class="fandoms hidden"></div>

        <!--<div>
            <div class="header3">Первоисточники</div>
            <div class="ui field"></div>
            <details>
                <summary class="select-header block">
                    <div class="select-header-expand">
                        <div class="expand-icon"><?= expand_more_icon ?></div>
                        Властелин колец
                    </div>
                    <div class="ui button small-button danger-accent-button"><?= delete_icon ?></div>
                </summary>
                <div class="select-content">
                    <div class="select-column-title">Название</div>
                    <div class="select-column-title">Тип медиа</div>
                    <div class="select-column-title">Год создания</div>
                    <div class="select-column-title">Создатель</div>
                    <div><input type="checkbox" name="" id="hobbit"><label for="hobbit">Хоббит</label></div>
                    <div>Мультфильм</div>
                    <div>1997</div>
                    <div>Джулз Басс</div>
                    <div><input type="checkbox" name="" id="fellowship"><label for="fellowship">Властелин колец: братство кольца</label></div>
                    <div>Мультфильм</div>
                    <div>1998</div>
                    <div>Ральф Бакши</div>
                    <div><input type="checkbox" name="" id="lord"><label for="lord">Властелин колец</label></div>
                    <div>Фильм</div>
                    <div>2001</div>
                    <div>Питер Джексон</div>
                </div>

            </details>
        </div>

        <div>
            <div class="header3">Персонажи</div>
            <div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>
        </div>

        <div>
            <div class="header3">Пейринги</div>
            <div class="ui button icon-button"><?= new_pairing_icon ?>Добавить пейринг</div>
        </div>-->

    </div>

</section>

<?= Html::submitButton('Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>