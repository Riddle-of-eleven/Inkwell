<?php
$this->title = Yii::$app->name.' – новая книга';

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
    'id' => 'form-login',
    'fieldConfig' => [
        'template' => "{input}\n{error}"
    ],
    'options' => ['class' => 'enter-form'],
])
?>

<section>
    <div class="head-article">
        <?= Html::a('Как грамотно оформить шапку книги?', ['']) ?>
    </div>
    <div class="header2">Основное</div>
    <div>
        <div class="field-header-words">
            <div class="header3">Название</div>
            <div class="symbol-count">0 / 100</div>
        </div>
        <div class="ui field">Чёрные птицы</div>
    </div>

    <div>
        <div class="field-header-words">
            <div class="header3">Описание</div>
            <div class="symbol-count">0 / 500</div>
        </div>
        <textarea></textarea>
    </div>

    <div>
        <div class="field-header-words">
            <div class="header3">Примечания</div>
            <div class="symbol-count">0 / 1000</div>
        </div>
        <textarea></textarea>
    </div>


    <div>
        <div class="field-header-words">
            <div class="header3">Дисклеймер</div>
            <div class="symbol-count">0 / 300</div>
        </div>
        <textarea></textarea>
    </div>


    <div>
        <div class="field-header-words">
            <div class="header3">Посвящение</div>
            <div class="symbol-count">0 / 300</div>
        </div>
        <textarea></textarea>
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
                    $('#genres-select').empty();
                    $.each(response, function(key, value) {
                        $('#genres-select').append(`<div class="dropdown-item" id="${key}">${value}</div>`);
                    });
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
                name: 'genres[]',
                value: id
            });
        $('.selected-items').append(hidden);
        let item = $('.selected-items').append(`<div class="selected-item">
                ${title}
                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" class="icon to-close" genre="${id}">
                    <path d="M291-253.847 253.847-291l189-189-189-189L291-706.153l189 189 189-189L706.153-669l-189 189 189 189L669-253.847l-189-189-189 189Z" />
                </svg>
            </div>`);
    });
    $('.selected-items').on('click', '.to-close', function() {
        console.log($(this).attr('genre'));
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
                ])?></div>
            <div class="dropdown-list block hidden" id="genres-select"></div>
        </div>
    </div>

    <div>
        <div class="field-header-words">
            <div class="header3">Теги</div>
           <!--<div class="symbol-count">0 / 40</div>-->
        </div>
        <!--<div class="tag-kinds"><div>Все</div><div>Предупреждения</div><div>Отношения</div><div>Формат</div><div>Место действия</div><div>Эпоха</div></div>-->
        <div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>
    </div>



</section>

<?= Html::submitButton('Далее', ['class' => 'ui button icon-button', 'name' => 'main-submit']) ?>
<? ActiveForm::end() ?>