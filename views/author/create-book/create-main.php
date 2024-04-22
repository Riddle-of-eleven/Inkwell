<?php
$this->title = 'Новая книга';

/* @var $model */
/* @var $relations */
/* @var $ratings */
/* @var $plan_sizes */
/* @var $genres */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

\app\assets\DashboardAsset::register($this);
$this->registerCss(<<<css
    form {
        display: flex; flex-direction: column; gap: 40px;
    }
css);

?>

<div class="header1">Добавление книги</div>
<div class="head-article">
    Прежде, чем опубликовать книгу, ознакомьтесь с <?= Html::a('правилами публикации', Url::to(['']), ['class' => 'highlight-link']) ?>.
</div>




<div class="steps">
    <div class="step active-step"><?=save_icon?> 1. Общая информация</div>
    <?=chevron_right_icon?>
    <div class="step"><?=fire_icon?> 2. Фэндомные сведения</div>
    <?=chevron_right_icon?>
    <div class="step"><?=imagesmode_icon?> 3. Обложка</div>
    <?=chevron_right_icon?>
    <div class="step"><?=person_icon?> 4. Доступ</div>
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
    <div class="head-article">
        <?= Html::a('Как грамотно оформить шапку книги?', ['']) ?>
    </div>
    <div class="header2">Основное</div>
    <div>
        <div class="field-header-words"><div class="header3">Название</div><!--<div class="symbol-count">0 / 100</div>--></div>
        <?= $f->field($model, 'title', [
            'options' => ['class' => 'ui field field-with-hint'],
            'inputOptions' => ['class' => ''],
            'template' => "{input}\n{hint}{error}",
        ])->textInput(['autofocus' => true, 'placeholder' => 'Название книги'])->label(false);?>
    </div>

    <div>
        <div class="field-header-words"><div class="header3">Описание</div><!--<div class="symbol-count">0 / 500</div>--></div>
        <?= $f->field($model, 'description')->textarea(['rows' => '6', 'placeholder' => 'Расскажите, о чём эта книга']) ?>
    </div>

    <div>
        <div class="field-header-words"><div class="header3">Примечания</div><!--<div class="symbol-count">0 / 1000</div>--></div>
        <?= $f->field($model, 'remark')->textarea(['rows' => '8', 'placeholder' => 'Здесь вы можете написать что-нибудь интересное']) ?>
    </div>


    <div>
        <div class="field-header-words"><div class="header3">Дисклеймер</div><!--<div class="symbol-count">0 / 300</div>--></div>
        <?= $f->field($model, 'disclaimer')->textarea(['rows' => '4', 'placeholder' => 'Если в книге содержатся моменты, о которых вы хотите предупредить читателей, впишите это сюда']) ?>
    </div>


    <div>
        <div class="field-header-words"><div class="header3">Посвящение</div><!--<div class="symbol-count">0 / 300</div>--></div>
        <?= $f->field($model, 'dedication')->textarea(['rows' => '4', 'placeholder' => 'Если книга посвящена кому-либо или чему-либо, напишите об этом здесь']) ?>
    </div>
</section>


<section>
    <div class="header2">Метаданные</div>
    <div class="dashboard-main-meta">
        <div>
            <div class="header3">Категория</div>
            <?= $f->field($model, 'relation')->radioList($relations, [
                'item' => function($index, $label, $name, $checked, $value) {
                    return "<div class='ui choice-input-block'><input type='radio' name='$name' id='relation-$value' value='$value'><label for='relation-$value'>$label</label></div>";
                }, 'class' => 'dashboard-choice']);
            ?>
        </div>
        <div>
            <div class="header3">Рейтинг</div>
            <?= $f->field($model, 'rating')->radioList($ratings, [
                'item' => function($index, $label, $name, $checked, $value) {
                    return "<div class='ui choice-input-block'><input type='radio' name='$name' id='rating-$value' value='$value'><label for='rating-$value'>$label</label></div>";
                }, 'class' => 'dashboard-choice']);
            ?>
        </div>
        <div>
            <div class="header3">Планируемый размер</div>
            <?= $f->field($model, 'plan_size')->radioList($plan_sizes, [
                'item' => function($index, $label, $name, $checked, $value) {
                    return "<div class='ui choice-input-block'><input type='radio' name='$name' id='plan-size-$value' value='$value'><label for='plan-size-$value'>$label</label></div>";
                }, 'class' => 'dashboard-choice']);
            ?>
        </div>
    </div>



<? $this->registerJs(<<<'js'
    $('#genres-input').on('input', function () {
        let input = $(this).val();
        $.ajax({
            url: 'index.php?r=author/create-book/find-genres',
            type: 'post',
            data: {input: input},
            success: function (response) {
                $('#genres-select').empty();
                $.each(response, function(key, value) {
                    $('#genres-select').append(`<div class="dropdown-item" id="${key}">${value}</div>`);
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('#genres-input').click(function () {
        if ($(this).val() == '') {
            $.ajax({
                url: 'index.php?r=author/create-book/find-genres',
                type: 'post',
                success: function (response) {
                    if (response) {
                        $('#genres-select').empty();
                        $.each(response, function(key, value) {
                            $('#genres-select').append(`<div class="dropdown-item" id="${key}">${value}</div>`);
                        });
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
        $('#genres-select').removeClass('hidden');
    });
    
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#genres-select').length && !$(e.target).closest('#genres-input').length) {
            $('#genres-select').addClass('hidden');
        }
    });
    
    $('#genres-select').on('click', '.dropdown-item', function() {
        let id = $(this).attr('id'), title = $(this).html();
        //let hiddens = $('input[type="hidden"][value="' + id + '"]');
        
        let hidden = $('<input>').attr({
                type: 'hidden',
                name: 'FormCreateMain[genres][]',
                value: id
            });
        $('.selected-items').append(hidden);
        let item = $('.selected-items').append(`<div class="selected-item" genre="${id}">
                ${title}
                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon" genre="${id}">
                    <path d="m339-301.847 141-141 141 141L658.153-339l-141-141 141-141L621-658.153l-141 141-141-141L301.847-621l141 141-141 141L339-301.847Zm141.067 185.846q-74.836 0-141.204-28.42-66.369-28.42-116.182-78.21-49.814-49.791-78.247-116.129-28.433-66.337-28.433-141.173 0-75.836 28.42-141.704 28.42-65.869 78.21-115.682 49.791-49.814 116.129-78.247 66.337-28.433 141.173-28.433 75.836 0 141.704 28.42 65.869 28.42 115.682 78.21 49.814 49.791 78.247 115.629 28.433 65.837 28.433 141.673 0 74.836-28.42 141.204-28.42 66.369-78.21 116.182-49.791 49.814-115.629 78.247-65.837 28.433-141.673 28.433ZM480-168q130 0 221-91t91-221q0-130-91-221t-221-91q-130 0-221 91t-91 221q0 130 91 221t221 91Zm0-312Z" />
                </svg>
            </div>`);
    });
    $('.selected-items').on('click', '.to-close', function() {
        let id = $(this).attr('genre');
        $(`input[type="hidden"][value="${id}"]`).remove();
        $(`[genre=${id}]`).remove();
    });
js, View::POS_END)?>

    <div>
        <div class="field-header-words">
            <div class="header3">Жанры</div>
            <!--<div class="symbol-count">0 / 10</div>-->
        </div>
        <!--<div class="tag-kinds"><div>Все</div><div>Структура</div><div>Содержание и тематика</div><div>Функция</div></div>-->
        <div class="selected-items"></div>
        <div class="field-with-dropdown">
            <div class="ui field"><?=Html::textInput('genres-input', null, [
                    'id' => 'genres-input',
                    'placeholder' => 'Введите первые несколько символов...',
                    'autocomplete' => 'off'
                ])?></div>
            <div class="dropdown-list block hidden" id="genres-select"></div>
        </div>
    </div>

    <!--
    <div>
        <div class="field-header-words">
            <div class="header3">Теги</div>
           <!-<div class="symbol-count">0 / 40</div>->
        </div>
        <!-<div class="tag-kinds"><div>Все</div><div>Предупреждения</div><div>Отношения</div><div>Формат</div><div>Место действия</div><div>Эпоха</div></div>->
        <div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>
    </div>
    -->



</section>

<?= Html::submitButton('Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>