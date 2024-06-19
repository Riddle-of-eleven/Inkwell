<?php
/* @var $chapter_title */

$this->title = 'Изменение части "' . $chapter_title . '"';

/** @var View $this */
/* @var Book $book*/

/* @var $chapter_type */
/* @var $chapter_text */

/* @var $chapter_section_position */
/* @var $chapter_chapter_position */

/* @var Chapter[] $chapters */
/* @var Chapter[] $sections */

use app\models\Tables\Book;
use app\models\Tables\Chapter;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\EditorAsset::register($this);
\app\assets\DashboardAsset::register($this);

$this->registerJsFile('@web/js/author/chapter/create.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/author/chapter/quill.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('@web/css/dashboards/steps.css');

// убирает лишние переносы строк
$chapter_text = str_replace(array("\r", "\n", "\r\n", "\t"), '', $chapter_text);

$this->registerJs(<<<js
    $('#modify-chapter-title').val('$chapter_title');

    const editor = $('.ql-editor'); 
    editor.html(`$chapter_text`);
    setCaret(editor[0]);
js);

$section_checked = $chapter_type == 'section' ? 'checked' : '';
$chapter_checked = $chapter_type == 'chapter' ? 'checked' : '';
$chapter_depend = $chapter_type == 'chapter' ? '' : 'hidden';

$session = Yii::$app->session;
//\yii\helpers\VarDumper::dump($session->get('modify.modify-chapter.section_position'));

?>

<div class="dashboard-header functional-header">
    <div>
        <h1 class="header1">Изменение части "<?=$chapter_title?>" (книга "<?=$book->title?>")</h1>
    </div>
    <div class="dashboard-actions">
        <div class="dashboard-main-actions">
            <?= Html::a(save_icon . 'Сохранить часть', Url::to(['author/modify/save-chapter']), ['class' => 'ui button icon-button']) ?>
            <?= Html::a(undo_icon . 'Вернуться к книге', Url::to(['author/modify/book']), ['class' => 'ui button icon-button']) ?>
        </div>
        <?= Html::a(new_book_icon . 'Удалить часть', Url::to(['author/modify/delete-chapter']), ['class' => 'ui button icon-button danger-accent-button']) ?>
    </div>
    <!--
    <div class="tip-color">Часть будет добавлена только после того, как вы решите её сохранить. До этого данные будут сохраняться локально у вас.</div>
    -->
</div>

<div class="inner-line"></div>


<section>
    <div class="header2">Основное</div>
    <div class="metadata-item direct-to-session">
        <label for="modify-chapter-title" class="header3 metadata-item-title">
            <div>Название <span class="required-symbol">*</span></div>
            <!--<span class="content-limit tip-color">150</span>-->
        </label>
        <div class="ui field"><input type="text" name="modify-chapter-title" id="modify-chapter-title" placeholder="Название части" maxlength="150"></div>
        <div class="input-error"></div>
    </div>

    <div class="metadata-item direct-to-session">
        <div class="header3">Тип части</div>
        <div class="head-article">Если вы хотите создать главу, выберите её и добавьте текст.</div>
        <div class="input-block-list" id="modify-chapter-type">
            <label class="ui choice-input-block">
                <input type='radio' name='chapter-type' value='section' <?=$section_checked?>>
                <span>
                    <div class="title-description">
                        Раздел
                        <div class="tip">Часть, которая может содержать главы.</div>
                    </div>
                </span>
            </label>
            <label class="ui choice-input-block">
                <input type='radio' name='chapter-type' value='chapter' <?=$chapter_checked?>>
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

    <section id="chapter-depend" class="<?=$chapter_depend?>">
        <div class="header2">Текст главы</div>
        <!--<div class="head-article">Вы можете написать текст вручную, скопировать его откуда-либо или загрузить файл.</div>-->

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
            <div class="head-article" style="margin: 0 0 14px">Допускаются файлы форматов <b>.odt</b> и <b>.docx</b>.</div>
            <div class="">
                <label class="upload-container">
                    <span class="upload-text highlight">Перетащите файл сюда</span>
                    <span class="upload-text">или</span>
                    <input type="file" name="modify-chapter-file" id="modify-chapter-file"
                           accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                    .odt,application/vnd.oasis.opendocument.text">
                    <span class="ui button icon-button"><?=backup_icon?>Загрузите его с устройства</span>
                </label>
            </div>
        </div>

    </section>

    <div class="header2">Позиционирование</div>
    <div class="head-article">Сначала выберите раздел, а потом конкретную главу, после которой хотите разместить новую.</div>

    <div class="metadata-item">
        <div class="header3">Выбор раздела</div>
        <!--<div class="head-article" style="margin: 0 0 14px">Допускаются файлы форматов <b>.odt</b> и <b>.docx</b>.</div>-->
        <div class="ui field">
            <select name="modify-chapter-section_position" id="modify-chapter-section_position">
                <option value="0">Без раздела</option>
                <? if ($sections) :
                    foreach ($sections as $section) :
                        $selected = $section->id == $chapter_section_position ? 'selected' : ''; ?>
                        <option value="<?=$section->id?>" <?=$selected?>><?=$section->title?></option>
                    <?endforeach;
                endif; ?>
            </select>
        </div>
    </div>
    <div class="metadata-item">
        <div class="header3">Позиция в книге</div>
        <!--<div class="head-article" style="margin: 0 0 14px">Допускаются файлы форматов <b>.odt</b> и <b>.docx</b>.</div>-->
        <div class="ui field">
            <select name="modify-chapter-chapter_position" id="modify-chapter-chapter_position">
                <option value="0">В начале</option>
                <? if ($chapters) :
                    foreach ($chapters as $chapter) :
                        $selected = $chapter->id == $chapter_chapter_position ? 'selected' : ''; ?>
                        <option value="<?=$chapter->id?>" <?=$selected?>><?=$chapter->title?></option>
                    <?endforeach;
                endif; ?>
            </select>
        </div>
    </div>

    <div class="inner-line"></div>

    <div class="dashboard-main-actions">
        <?= Html::a(save_icon . 'Сохранить часть', Url::to(['author/modify/save-chapter']), ['class' => 'ui button icon-button']) ?>
        <?= Html::a(new_book_icon . 'Удалить часть', Url::to(['']), ['class' => 'ui button icon-button danger-accent-button']) ?>
    </div>

</section>