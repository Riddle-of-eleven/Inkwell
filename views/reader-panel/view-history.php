<?php
$this->title = 'История просмотра';

/* @var $views */

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\BookDisplay;
use yii\i18n\Formatter;
use yii\helpers\VarDumper;

$this->registerCssFile("@web/css/parts/user/reader-panel.css");

$formatter = new Formatter();
?>

<div>
    <h1>История просмотра</h1>
    <div class="tip-color">Здесь сохраняются все книги, которые вы просматривали</div>
</div>





<? if ($views)
    foreach ($views as $key => $view) {?>
        <details class="view-history">
            <summary class="block"><div class="expand-icon"><?= expand_more_icon ?></div><div class=""><?=$formatter->asDate($key, 'dd MMMM yyyy')?></div></summary>
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
                    <? echo BookDisplay::widget(['data' => new \app\models\_BookData($id)]);
                } ?>

            </div>
        </details>
    <? }?>