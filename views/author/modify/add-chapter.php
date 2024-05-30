<?php
$this->title = 'Добавление части';

/** @var View $this */
/* @var Book $book*/

use app\models\Tables\Book;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\EditorAsset::register($this);
\app\assets\DashboardAsset::register($this);

$this->registerJsFile('@web/js/author/chapter/create.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>

<div class="dashboard-header functional-header">
    <div>
        <h1 class="header1">Добавление части к книге "<?=$book->title?>"</h1>
    </div>
    <div class="dashboard-actions">
        <div class="dashboard-main-actions">
            <div class="ui button icon-button"><?=save_icon?>Сохранить часть</div>
            <?= Html::a(undo_icon . 'Вернуться к книге', Url::to(['author/modify/book']), ['class' => 'ui button icon-button']) ?>
        </div>
        <?= Html::a(new_book_icon . 'Удалить часть', Url::to(['']), ['class' => 'ui button icon-button danger-accent-button']) ?>
    </div>
    <div class="tip-color">Часть будет добавлена только после того, как вы решите её сохранить. До этого данные будут сохраняться локально у вас</div>
</div>

<div class="inner-line"></div>


<section>
    <div class="header2">Тип части</div>
    <div class="head-article">Если вы хотите создать главу, выберите её и добавьте текст.</div>
    <div class="metadata-item direct-to-session">
        <div class="input-block-list" id="create-chapter-type">
            <label class="ui choice-input-block">
                <input type='radio' name='chapter-type' value='section'>
                <span>
                    <div class="title-description">
                        Раздел
                        <div class="tip">Часть, которая может содержать главы.</div>
                    </div>
                </span>
            </label>
            <label class="ui choice-input-block">
                <input type='radio' name='chapter-type' value='chapter'>
                <span>
                    <div class="title-description">
                        Глава
                        <div class="tip">Часть с текстовым содержимом, может быть в разделе.</div>
                    </div>
                </span>
            </label>
        </div>
        <div class="input-error"></div>
    </div>

    <div class="header2">Текст части</div>
    <div class="head-article">Вы можете написать текст вручную, скопировать его откуда-либо или загрузить файл.</div>

    <div class="metadata-item">
        <div class="header3">Текстовый редактор</div>
        <div class="editor-container">
            <div id="toolbar-container">
                <div class="toolbar-item">
                    <div class="toolbar-title">Выравнивание:</div>
                    <span class="ql-formats">
                        <button class="ql-align" value=""></button>
                        <button class="ql-align" value="center"></button>
                        <button class="ql-align" value="right"></button>
                    </span>
                </div>
                <div class="toolbar-item">
                    <div class="toolbar-title">Выделение текста:</div>
                    <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                </span>
                </div>
            </div>
            <div id="editor"></div>
        </div>
    </div>

    <div class="metadata-item">
        <div class="header3">Загрузка файла</div>
        <div class="head-article" style="margin: 14px 0">Допускаются файлы форматов <b>.docx</b> и <b>.odt</b>.</div>
        <div class="">
            <label class="upload-container">
                <span class="upload-text highlight">Перетащите файл сюда</span>
                <span class="upload-text">или</span>
                <input type="file" name="create-chapter-file" id="create-chapter-file"
                       accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                .odt,application/vnd.oasis.opendocument.text">
                <span class="ui button icon-button"><?=backup_icon?>Загрузите его с устройства</span>
            </label>
        </div>
    </div>

    <div class="header2">Позиционирование</div>
</section>