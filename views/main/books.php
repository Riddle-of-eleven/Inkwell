<?php
$this->title = Yii::$app->name.' – все книги';


/* @var $book */


use app\widgets\BookDisplay;
use yii\helpers\VarDumper;


echo BookDisplay::widget(['data' => $book]);


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
