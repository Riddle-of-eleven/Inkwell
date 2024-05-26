<?php

/* @var Book[] $books*/

use app\models\Tables\Book;
use app\models\_BookData;
use app\widgets\PanelBookDisplay;
use yii\helpers\VarDumper;


foreach ($books as $book) {
    //VarDumper::dump($book, 10, true);
    $data_progress = new _BookData($book->id);
    echo PanelBookDisplay::widget(['data' => $data_progress]);
}