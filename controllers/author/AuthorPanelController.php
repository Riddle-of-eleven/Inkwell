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

        $books_progress = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 1])->all();
        $books_complete = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 2])->all();
        $books_frozen = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 3])->all();
        $books_draft = Book::find()->where(['user_id' => $user])->andWhere(['is_draft' => 1])->all();

        return $this->render('books-dashboard', [
            'books_progress' => $books_progress,
            'books_complete' => $books_complete,
            'books_frozen' => $books_frozen,
            'books_draft' => $books_draft,
        ]);
    }

    public function actionBook()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('book');
    }
}