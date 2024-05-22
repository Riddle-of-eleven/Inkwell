<?php

/** @var yii\web\View $this */
/** @var $books */
$this->title = Yii::$app->name;

use app\widgets\BookDisplay;

if ($books) foreach ($books as $book) {
    echo BookDisplay::widget(['data' => $book]);
}

