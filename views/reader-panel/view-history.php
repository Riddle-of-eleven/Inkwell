<?php
$this->title = 'История просмотра';

/* @var $views */

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\BookDisplay;
use yii\i18n\Formatter;
use yii\helpers\VarDumper;
use app\models\Tables\Book;

$this->registerCssFile("@web/css/parts/user/reader-panel.css");
$this->registerCssFile("@web/css/parts/user/author.css");

$formatter = new Formatter();
?>

<div>
    <div class="header1">История просмотра</div
    <div class="tip-color">Здесь сохраняются все книги, которые вы просматривали</div>
</div>


<? if ($views)
    foreach ($views as $key => $view) {?>
        <details class="view-history">
            <summary class="block select-header">
                <div class="select-header-expand"><?=expand_more_icon?><?=$formatter->asDate($key, 'dd MMMM yyyy')?></div>
            </summary>
            <div class="contents">
                <? foreach ($view as $id => $times) { ?>
                    <div class="view-info block tip">Вы просматривали эту книгу в
                        <? $first = true; foreach ($times as $time) {
                            if ($first == true) {
                                $first = false;
                                echo $time;
                            }
                            else echo ', '.$time;
                        }?>
                    </div>
                    <? echo BookDisplay::widget(['book' => Book::findOne($id)]);
                } ?>

            </div>
        </details>
    <? }
    else echo '<div class="block author-about"><div class="tip-color">Вы не просматривали книг.</div></div>';
