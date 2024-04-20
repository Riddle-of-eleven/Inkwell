<?php

namespace app\controllers\author;

use app\models\Book;
use Yii;
use yii\web\Controller;

class AuthorPanelController extends Controller
{
    public function actionBooksDashboard() {
        if (Yii::$app->user->isGuest) return $this->goHome();

        $user = Yii::$app->user->identity->id;
        //$books = Book::find()->where(['user_id' => $user])->all();
        $progress = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 1])->andWhere(['<>', 'is_draft', 1])->andWhere(['<>', 'is_process', 1]);
        $complete = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 2])->andWhere(['<>', 'is_draft', 1])->andWhere(['<>', 'is_process', 1]);
        $frozen = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 3])->andWhere(['<>', 'is_draft', 1])->andWhere(['<>', 'is_process', 1]);
        $draft = Book::find()->where(['user_id' => $user])->andWhere(['is_draft' => 1])->andWhere(['<>', 'is_process', 1]);
        $process = Book::find()->where(['user_id' => $user])->andWhere(['is_process' => 1]);

        $books_progress = $progress->all();
        $books_complete = $complete->all();
        $books_frozen = $frozen->all();
        $books_draft = $draft->all();
        $books_process = $process->all();

        /*$count_progress = $progress->count();
        $count_complete = $complete->count();
        $count_frozen = $frozen->count();
        $count_draft = $draft->count();
        $count_process = $process->count();*/

        return $this->render('books-dashboard', [
            'books_progress' => $books_progress,
            'books_complete' => $books_complete,
            'books_frozen' => $books_frozen,
            'books_draft' => $books_draft,
            'books_process' => $books_process,
        ]);
    }

    public function actionBook()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('book');
    }
}