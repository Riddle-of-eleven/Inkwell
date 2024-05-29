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

//VarDumper::dump($leaves[5], 10, true);

$formatter = new Formatter();

?>

<div class="header2">Оглавление</div>

<? if ($roots) : ?>
    <div class="modify-toc">
    <? foreach ($roots as $root) :
        if ($root->is_section) : ?>
            <details class="toc-section modify-toc" open>
                <summary class="block toc-section-title modify-toc-section-title" data-id="<?=$root->id?>">
                    <div class="select-header-expand">
                        <div class="expand-icon"><?=expand_more_icon?></div>
                        <?=$root->title?>
                    </div>
                    <div class="toc-action-buttons">
                        <div class="ui button small-button"><?=edit_icon?></div>
                        <div class="ui button small-button danger-accent-icon-button"><?=delete_icon?></div>
                    </div>
                </summary>
                <div class="toc-chapters">
                    <? foreach ($leaves[$root->id] as $leaf) : ?>
                        <div class="block toc-chapter" data-id="<?=$leaf->id?>">
                            <div class="chapter-title"><?= $leaf->title ?></div>
                            <div class="chapter-meta">
                                <div class="chapter-date">
                                    <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($leaf->created_at, 'd MMMM yyyy'); ?></div></div>
                                </div>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </details>
        <? else : ?>
            <div class="block toc-chapter" data-id="<?=$root->id?>">
                <div class="chapter-title"><?= $root->title ?></div>
                <div class="chapter-meta">
                    <div class="chapter-date">
                        <div class="stats-pair"><div>Дата публикации:</div><div><?= $formatter->asDate($root->created_at, 'd MMMM yyyy'); ?></div></div>
                    </div>
                </div>
            </div>
        <? endif;
    endforeach; ?>
    </div>
<? endif; ?>


<div class="inner-line background-line"></div>
<?=Html::a(new_chapter_icon . 'Добавить часть', Url::to(['author/modify/add-chapter']), ['class' => 'ui button icon-button'])?>

