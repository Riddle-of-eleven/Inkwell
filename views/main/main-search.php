<?php
$this->title = 'Результаты поиска';

/* @var View $this */
/* @var $books Book[] */
/* @var $authors User[] */

use app\models\Tables\Book;
use app\models\Tables\User;
use yii\web\View;
use yii\helpers\VarDumper;

VarDumper::dump($books);
VarDumper::dump($authors);

?>


