<?php

/* @var Book[] $books*/

use app\models\Tables\Book;
use app\models\_BookData;
use app\widgets\PanelBookDisplay;
use yii\helpers\VarDumper;


foreach ($books as $book) {
    echo PanelBookDisplay::widget(['book' => $book]);
}