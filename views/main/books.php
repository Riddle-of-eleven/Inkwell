<?php
$this->title = Yii::$app->name.' – все книги';


/* @var $data */


use app\widgets\BookDisplay;
use yii\helpers\VarDumper;


//echo BookDisplay::widget(['data' => $from_controller]);


//VarDumper::dump($data, 10, true);


foreach ($data as $datum) {
    VarDumper::dump($datum->id, 10, true);
}
