<?php

namespace app\controllers\author;

use app\models\Book;
use app\models\Fandom;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
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

    public function actionBook() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('book');
    }

    public function actionFandomsDashboard() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $fandoms = Fandom::find()->where(['this_creator_id' => Yii::$app->user->identity->id])->all();

        return $this->render('fandoms-dashboard', [
            'fandoms' => $fandoms,
        ]);
    }

    public function actionChangeFandom() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $id = Yii::$app->request->get('id');
        $fandom = Fandom::findOne($id);

        if ($fandom->load(Yii::$app->request->post()) && $fandom->save()) {
            //VarDumper::dump($fandom, 10, true);
            return $this->redirect(Url::to(['author/author-panel/fandoms-dashboard']));
        }

        return $this->render('change-fandom',[
            'fandom' => $fandom,
        ]);
    }
}