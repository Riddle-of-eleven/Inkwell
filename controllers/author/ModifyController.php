<?php

namespace app\controllers\author;

use app\models\_ContentData;
use app\models\Tables\Book;
use app\models\Tables\Chapter;
use Yii;
use yii\web\Controller;

class ModifyController extends Controller
{
    public function actionBook($book) {
        $session = Yii::$app->session;
        $tab = $session->has('modify.book.tab') ? $session->get('modify.book.tab') : 'main';

        if (!$book) return $this->goHome();
        $session->set('modify.book', $book);
        $this_book = Book::findOne($book);

        return $this->render('book', [
            'tab' => $tab,
            'book' => $this_book
        ]);
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
}