<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\Book;
use app\models\Tag;
use yii\helpers\VarDumper;
use yii\i18n\Formatter;
use yii\web\Controller;
use Yii;


// класс для главных страниц по определённым категориям, например, книгам, фэндомам, etc
class MainController extends Controller
{
    public function actionBooks() {

//        $book = Book::findOne(1);
//        $genres = $book->genres;
//        $tags = $book->tags;

        /*$books = Book::find()->all();

        foreach ($books as $book) {
            VarDumper::dump($book->tags, 10, true);
        }*/


        $book = new _BookData(1);
        //VarDumper::dump($book, 10, true);



        //die;
        return $this->render('books', [
            'book' => $book
        ]);
    }
}