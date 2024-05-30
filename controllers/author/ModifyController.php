<?php

namespace app\controllers\author;

use app\models\_ContentData;
use app\models\Tables\Book;
use app\models\Tables\Chapter;
use yii\helpers\Url;
use Yii;
use yii\web\Controller;

class ModifyController extends Controller
{
    public function actionBook() {
        $session = Yii::$app->session;
        $tab = $session->has('modify.book.tab') ? $session->get('modify.book.tab') : 'main';
        $book = $session->has('modify.book') ? $session->get('modify.book') : null;

        if (!$book) return $this->goHome();
        $this_book = Book::findOne($book);

        return $this->render('book', [
            'tab' => $tab,
            'book' => $this_book
        ]);
    }
    public function actionDefineModify($book) {
        $session = Yii::$app->session;
        if (!$book) return $this->goHome();
        $session->set('modify.book', $book);
        return $this->redirect(Url::to(['author/modify/book']));
    }


    public function actionLoadMain() {
        $session = Yii::$app->session;
        $session->set('modify.book.tab', 'main');

        $book = Book::findOne($session->get('modify.book'));

        return $this->renderAjax('tabs/main', [
            'book' => $book,
        ]);
    }

    public function actionLoadChapters() {
        $session = Yii::$app->session;
        $session->set('modify.book.tab', 'chapters');

        $book = Book::findOne($session->get('modify.book'));
        $roots = Chapter::find()->where(['book_id' => $book->id, 'parent_id' => null])->orderBy('order')->all();
        $leaves = [];
        if ($roots)
            foreach ($roots as $root) {
                $leaves[$root->id] = Chapter::find()->where(['book_id' => $book->id, 'parent_id' => $root->id])->orderBy('order')->all();
            }

        return $this->renderAjax('tabs/chapters', [
            'book' => $book,
            'roots' => $roots,
            'leaves' => $leaves,
        ]);
    }



    public function actionAddChapter() {
        $session = Yii::$app->session;
        $book = $session->has('modify.book') ? $session->get('modify.book') : null;
        if (!$book) return $this->goHome();
        $this_book = Book::findOne($book);
        return $this->render('add-chapter', [
            'book' => $this_book,
        ]);
    }
}