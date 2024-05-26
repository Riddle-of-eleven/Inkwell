<?php
$this->title = 'Ориджиналы';

/* @var $originals */
/* @var $pages */

use yii\widgets\LinkPager;
use app\widgets\BookDisplay;

?>

<h1 class="header1">Ориджиналы</h1>
<div class="head-article">
    На этой странице отображаются ориджиналы – оригинальные истории, от начала и до конца придуманные авторами Inkwell.
</div>

<? foreach ($originals as $original) echo BookDisplay::widget(['book' => $original]);

LinkPager::widget([
    'pagination' => $pages,
]);