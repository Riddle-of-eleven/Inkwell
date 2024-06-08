<?php
$this->title = ' – книга';

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\DashboardAsset::register($this);

?>

<div class="dashboard-header functional-header">
    <div>
        <h1>Редактирование книги "Чёрные птицы"</h1>
    </div>
    <div class="dashboard-actions">
        <div class="dashboard-main-actions">
            <div class="ui button icon-button"><?= save_icon ?>Сохранить изменения</div>
            <div class="vertical-line"></div>
            <div class="ui button icon-button"><?= new_chapter_icon ?>Добавить часть</div>
            <div class="ui button icon-button"><?= file_open_icon ?>Посмотреть книгу</div>
        </div>
        <?= Html::a(new_book_icon . 'Удалить книгу', Url::to(['']), ['class' => 'ui button icon-button danger-accent-button']) ?>
    </div>
</div>


<div class="tab-header">
    <div class="tab active-tab" data-tab="1"><?= description_icon ?>Общая информация</div>
    <div class="tab" data-tab="2"><?= library_books_icon ?>Части</div>
    <div class="tab" data-tab="3"><?= group_icon ?>Доступ</div>
    <div class="tab" data-tab="4"><?= bar_chart_icon ?>Статистика</div>
    <div class="tab" data-tab="5"><?= branch_icon ?>Версии и изменения</div>
    <div class="tab" data-tab="6"><?= deployed_code_icon ?>Проект</div>
</div>

<div class="tab-contents dashboard-tab">
    <div class="tab-content active-tab" data-tab="1">
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

        <div class="line"></div>

        <section>
            <div class="header2">Метаданные</div>
            <div class="dashboard-main-meta">
                <div>
                    <div class="header3">Категория</div>
                    <div class="dashboard-choice">
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="gen"><label for="gen">Джен</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="get"><label for="get">Гет</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="slash"><label for="slash">Слэш</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="femslash"><label for="femslash">Фемслэш</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="platonic"><label for="platonic">Платоник</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="nonfic"><label for="nonfic">Нонфик</label></div>
                    </div>
                </div>
                <div>
                    <div class="header3">Рейтинг</div>
                    <div class="dashboard-choice">
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="g"><label for="g">G</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="pg"><label for="pg">PG-13</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="r"><label for="r">R</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="nc"><label for="nc">NC</label></div>
                    </div>
                </div>
                <div>
                    <div class="header3">Планируемый размер</div>
                    <div class="dashboard-choice">
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="drabble"><label for="drabble">Драббл</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="mini"><label for="mini">Мини</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="midi"><label for="midi">Миди</label></div>
                        <div class="ui choice-input-block"><input type="radio" name="relation" id="maxi"><label for="maxi">Макси</label></div>
                    </div>
                </div>
            </div>


            <div>
                <div class="field-header-words">
                    <div class="header3">Жанры</div>
                    <div class="symbol-count">0 / 10</div>
                </div>
                <div class="tag-kinds">
                    <div>Все</div>
                    <div>Структура</div>
                    <div>Содержание и тематика</div>
                    <div>Функция</div>
                </div>
                <div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>
            </div>

            <div>
                <div class="field-header-words">
                    <div class="header3">Теги</div>
                    <div class="symbol-count">0 / 40</div>
                </div>
                <div class="tag-kinds">
                    <div>Все</div>
                    <div>Предупреждения</div>
                    <div>Отношения</div>
                    <div>Формат</div>
                    <div>Место действия</div>
                    <div>Эпоха</div>
                </div>
                <div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>
            </div>

        </section>

        <div class="line"></div>

        <section>
            <div class="head-article">
                <?= Html::a('В чём разница между фэндомом и первоисточником?', ['']) ?>
            </div>
            <div class="header2">Фэндомные сведения</div>

            <div>
                <div class="header3">Тип книги</div>
                <div><input type="radio" name="book-type" id="original"><label for="original">Ориджинал</label></div>
                <div><input type="radio" name="book-type" id="fanfic"><label for="fanfic">Фанфик</label></div>
            </div>

            <div>
                <div class="header3">Фэндомы</div>
                <div class="ui field"><input type="text" placeholder="Введите первые несколько символов"></div>
            </div>

            <div>
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
            </div>

        </section>

        <div class="line"></div>

        <section>
            <div class="head-article">
                <?= Html::a('Как выбрать обложку?', ['']) ?>
            </div>
            <div class="header2">Обложка</div>
            <div class="ui button icon-button"><?= add_photo_alternate_icon ?>Добавить обложку</div>
        </section>

        <div class="line"></div>

        <section>
            <div class="header2">Статус и видимость</div>
        </section>
    </div>


    <div class="tab-content" data-tab="2">Части</div>
    <div class="tab-content" data-tab="3">Доступ</div>
    <div class="tab-content" data-tab="4">Статистика</div>
    <div class="tab-content" data-tab="5">Версии и изменения</div>
    <div class="tab-content" data-tab="6">Проект</div>
</div>
