<?php

namespace app\controllers;

use app\models\Book;
use yii\web\Controller;


// класс для главных страниц по определённым категориям, например, книгам, фэндомам, etc
class MainController extends Controller
{
    public function actionBooks() {

        //$books = Book::find()->all();

        $book = Book::find()->joinWith('user')->all();
        /*$author = $book->user;
        $relation = $book->relation0->title;*/

        return $this->render('books', [
            'data' => $book,
        ]);
    }
}