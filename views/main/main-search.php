<?php
$this->title = 'Результаты поиска';

/* @var View $this */
/* @var $books Book[] */
/* @var $authors User[] */

use app\models\Tables\Book;
use app\models\Tables\User;
use yii\web\View;
use yii\helpers\VarDumper;
use app\widgets\BookDisplay;
use app\widgets\AuthorDisplay;

/*VarDumper::dump($books);
VarDumper::dump($authors);*/

?>


<div class="header1">Результаты поиска</div>

<div class="header2">Книги</div>
<section>
    <? if ($books)
        foreach ($books as $book) {
            echo BookDisplay::widget(['book' => $book]);
        }
        else echo '<div class="center-container tip-color">Ничего не найдено</div>';
    ?>
</section>


<div class="header2">Авторы</div>
<section class="user-list">
    <? if ($authors)
        foreach ($authors as $author) {
            echo AuthorDisplay::widget(['author' => $author]);
        }
    else echo '<div class="center-container tip-color">Ничего не найдено</div>';
    ?>
</section>
