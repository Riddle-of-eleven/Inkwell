<?php
$this->title = 'Корзина';

/** @var $this View */
/** @var $recycles Book[] */

use app\models\Tables\Book;
use yii\web\View;
use app\widgets\PanelBookDisplay;

\app\assets\DashboardAsset::register($this);
$this->registerCssFile('@web/css/dashboards/book.css');

?>

<div class="dashboard-header">
    <div>
        <div class="header1">Корзина</div>
        <div class="tip-color">Здесь отображаются ваши недавно удалённые книги.</div>
    </div>
</div>

<?

foreach ($recycles as $recycle) {
    echo PanelBookDisplay::widget(['book' => $recycle]);
}
