<?php
$this->title = 'Все книги';


/* @var $books Book[] */


use app\models\Tables\Book;
use app\widgets\BookDisplay;
use yii\helpers\VarDumper;

?>


<div class="header1">Все книги</div>

<? if ($books) :
    foreach ($books as $book) {
        echo BookDisplay::widget(['book' => $book]);
    }
endif;

/*foreach ($genres as $genre) {
    echo $genre->title . ', ';
}
foreach ($tags as $tag) {
    echo $tag->title . ', ';
}*/

//VarDumper::dump($data, 10, true);

/*foreach ($data as $datum) {
    VarDumper::dump($datum, 10, true);
    echo '<hr>';
}*/


//var_dump($book);
