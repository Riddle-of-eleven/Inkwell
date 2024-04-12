<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\_ContentData;
use app\models\Book;
use app\models\Chapter;
use app\models\Tag;
use yii\helpers\VarDumper;
use yii\i18n\Formatter;
use yii\web\Controller;
use Yii;
use yii\helpers\Url;


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


        $book = new _BookData(2);
        //VarDumper::dump($book, 10, true);



        //die;
        return $this->render('books', [
            'book' => $book,
        ]);
    }



    public function actionRandBook()
    {
        $ids = Book::find()->select('id')->column();
        $id = array_rand($ids);
        $url = Url::toRoute(['book', 'id' => $ids[$id]]);
        Yii::$app->getResponse()->redirect($url);
    }

    public function actionBook()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $book = new _BookData($id);
        $content = new _ContentData($id);

        return $this->render('book', [
            'book' => $book,
            'content' => $content,
        ]);
    }

    public function actionAuthor()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
    }
}


