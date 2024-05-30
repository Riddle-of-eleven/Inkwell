<?php
/* @var $books Book[] */
/* @var $interaction */

use app\models\Tables\Book;
use app\widgets\BookDisplay;
use yii\helpers\VarDumper;

//VarDumper::dump($books, 10, true);


$replacement = '';
if ($interaction == 'like') $replacement = 'Вы не добавили в понравившееся ни одной книги';
else if ($interaction == 'favorite') $replacement = 'Вы не добавили в избранные ни одной книги';
else if ($interaction == 'read') $replacement = 'Вы не добавили в прочитанное ни одной книги';
else if ($interaction == 'later') $replacement = 'Вы не отложили на потом ни одной книги';

if ($books)
    foreach ($books as $book) {
        echo BookDisplay::widget(['book' => $book]);
    }
else echo "<div class='center-container tip-color'>$replacement</div>";