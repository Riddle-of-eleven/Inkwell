<?php
/** @var View $this */

/* @var $book Book */
/* @var $roots Chapter[] */
/* @var $leaves Chapter[] */

use app\models\Tables\Book;
use app\models\Tables\Chapter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\i18n\Formatter;

$this->registerCssFile("@web/css/parts/book/book.css");

//VarDumper::dump($roots, 10, true);

$formatter = new Formatter();

?>

<div class="header2">Оглавление</div>

<?=Html::a(new_chapter_icon . 'Добавить часть', Url::to(), ['class' => 'ui button icon-button'])?>

<? if ($roots)
    foreach ($roots as $root) :
        if ($root->is_section) : ?>
            <details class="toc-section" open>
                <summary class="block toc-section-title">
                    <div class="select-header-expand"><?=expand_more_icon?><?=$root->title?></div>
                </summary>

            </details>
        <? else : ?>
            <div class="block toc-chapter">
                <div class="chapter-title"><?= $root->title ?></div>
                <div class="chapter-meta">
                    <div class="chapter-date">
                        <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($root->created_at, 'd MMMM yyyy'); ?></div></div>
                    </div>
                </div>
            </div>
        <? endif;
    endforeach;