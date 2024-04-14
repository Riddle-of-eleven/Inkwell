<?php
$this->title = Yii::$app->name.' – библиотека';

?>

<div class="dashboard-header">
    <div>
        <h1>Книги</h1>
        <div class="tip">На этой странице отображаются все книги, автором которых вы являетесь.</div>
    </div>
    <?= Html::a(new_book_icon . 'Добавить книгу', Url::to(['main/rand-book']), ['class' => 'ui button icon-button accent-button']) ?>
</div>