<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\_ContentData;
use app\models\Book;
use app\models\Chapter;
use app\models\FavoriteBook;
use app\models\Like;
use app\models\Read;
use app\models\ReadLater;
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

        $like = false; $read = false; $read_later = false; $favorite = false;
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->id;
            $like = Like::find()->select(['id', 'liked_at'])->where(['book_id' => $id])->andWhere(['user_id' => $user])->one();
            $read = Read::find()->select(['id', 'read_at'])->where(['book_id' => $id])->andWhere(['user_id' => $user])->andWhere(['chapter_id' => null])->one();
            $read_later = ReadLater::find()->select(['id', 'added_at'])->where(['book_id' => $id])->andWhere(['user_id' => $user])->one();
            $favorite = FavoriteBook::find()->select('id')->where(['book_id' => $id])->andWhere(['user_id' => $user])->one();

            // создаётся дефолтный сборник с соответствующим названием
            //$read_later =
        }

        return $this->render('book', [
            'book' => $book,
            'content' => $content,
            'like' => $like,
            'read' => $read,
            'read_later' => $read_later,
            'favorite' => $favorite,
        ]);
    }

    public function actionAuthor()
    {
        $request = Yii::$app->request;
        $id = $request->get('id');
    }
}


