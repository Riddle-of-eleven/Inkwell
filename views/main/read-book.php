<?php
$this->title = Yii::$app->name.' – книга';

$this->registerCssFile("@web/css/parts/book/reader.css");

?>

<div class="center-container reader">
    <div class="reading-progress">
        <div class="progress-bar"><div class="current-progress"></div></div>
        <div class="tip">24%</div>
    </div>

    <div class="reader-header block">
        <div class="reader-header-left">
            <button class="ui button small-button"><?=keyboard_double_arrow_left_icon?></button>
            <div class="header2">Хорей</div>
        </div>
        <div class="reader-header-right">
            <div class="action-buttons">
                <button class="ui button small-button"><?=favorite_icon?></button>
                <button class="ui button small-button"><?=list_alt_add_icon?></button>
                <button class="ui button small-button"><?=palette_icon?></button>
            </div>
            <div class="vertical-line"></div>
            <a href="" class="ui button icon-button danger-accent-button"><?=cancel_icon?>Выйти из читалки</a>
        </div>
    </div>

    <div class="reader-navigation">
        <button class="ui button icon-button"><?=previous_icon?>Предыдущая глава</button>
        <button class="ui button icon-button"><?=news_icon?>Оглавление</button>
        <button class="ui button icon-button"><?=resume_icon?>Следующая глава</button>
    </div>

    <div class="reader-content block">
        <div class="reader-book-header">
            <div class="header2">Still Loving You</div>
            <div class="tip">26 марта 2024, 23.41</div>
        </div>

        <div class="reader-book-text">
            Вот он, настоящий пельмень. Внутри много-много мяса, мало-мало теста.
        </div>
    </div>

    <div class="reader-navigation">
        <button class="ui button icon-button"><?=previous_icon?>Предыдущая глава</button>
        <button class="ui button icon-button"><?=news_icon?>Оглавление</button>
        <button class="ui button icon-button"><?=resume_icon?>Следующая глава</button>
    </div>

    <div class="line"></div>
</div>

<div class="header2">Комментарии</div>

<div class="comment-form">
    <div class="author-avatar"></div>
    <div class="add-comment">
        <textarea name="" id="" rows="3"></textarea>
        <div class="under-comment">
            <div class="tip">Здесь вы можете похвалить автора или высказать критику. Помните, что некорректные комментарии могут быть удалены.</div>
            <div class="ui button icon-button"><?=send_icon?>Отправить</div>
            <div class="symbol-count">2000</div>
        </div>
    </div>
</div>

<div class="comments">
    <div class="comment">
        
    </div>
    <details>
        <summary class="block">
            <div class="expand-icon"><?= expand_more_icon ?></div>
            <div class="">Ответы</div>
        </summary>
        <div class="comment"></div>
    </details>
</div>