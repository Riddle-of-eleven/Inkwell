<?php
$this->title = 'Фанфики';

/* @var $fanfics */
/* @var $pages */

use yii\widgets\LinkPager;
use app\widgets\BookDisplay;

?>

<h1 class="header1">Фанфики</h1>
<div class="head-article">
    Здесь вы видите все фанфики – фанатские работы, созданные по мотивам уже существующих произведений.
</div>

<? foreach ($fanfics as $original) echo BookDisplay::widget(['book' => $original]);
echo LinkPager::widget(['pagination' => $pages]);