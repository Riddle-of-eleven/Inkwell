<?php

namespace app\controllers\author;

use app\models\Tables\Book;
use app\models\Tables\Fandom;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;

class AuthorPanelController extends Controller
{
    public function actionBooksDashboard() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $session = Yii::$app->session;
        $tab = $session->has('author-panel.book-dashboard.tab') ? $session->get('author-panel.book-dashboard.tab') : 'progress';

        $user = Yii::$app->user->identity->id;
        $progress = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 1])->andWhere(['<>', 'is_draft', 1])->all();
            //->innerJoinWith('recycleBins as bin')->where(['<>', 'bin.user_id', $user])->all();
        $complete = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 2])->andWhere(['<>', 'is_draft', 1]);
        $frozen = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 3])->andWhere(['<>', 'is_draft', 1]);
        $draft = Book::find()->where(['user_id' => $user])->andWhere(['is_draft' => 1]);

        //VarDumper::dump($progress, 10, true); die;

        /*$books_progress = $progress->all();
        $books_complete = $complete->all();
        $books_frozen = $frozen->all();
        $books_draft = $draft->all();*/

        $count_progress = $progress->count();
        $count_complete = $complete->count();
        $count_frozen = $frozen->count();
        $count_draft = $draft->count();

        return $this->render('dashboard/books', [
            'tab' => $tab,
            'progress' => $count_progress,
            'complete' => $count_complete,
            'frozen' => $count_frozen,
            'draft' => $count_draft,
        ]);
    }
    public function actionLoadProgress() {
        $session = Yii::$app->session;
        $session->set('author-panel.book-dashboard.tab', 'progress');

        $user = Yii::$app->user->identity->id;
        $progress = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 1])->andWhere(['<>', 'is_draft', 1])->all();

        return $this->renderAjax('dashboard/view', [
            'books' => $progress,
        ]);
    }
    public function actionLoadComplete() {
        $session = Yii::$app->session;
        $session->set('author-panel.book-dashboard.tab', 'complete');

        $user = Yii::$app->user->identity->id;
        $complete = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 2])->andWhere(['<>', 'is_draft', 1])->all();

        return $this->renderAjax('dashboard/view', [
            'books' => $complete,
        ]);
    }
    public function actionLoadFrozen() {
        $session = Yii::$app->session;
        $session->set('author-panel.book-dashboard.tab', 'frozen');

        $user = Yii::$app->user->identity->id;
        $frozen = Book::find()->where(['user_id' => $user])->andWhere(['completeness_id' => 3])->andWhere(['<>', 'is_draft', 1])->all();

        return $this->renderAjax('dashboard/view', [
            'books' => $frozen,
        ]);
    }
    public function actionLoadDraft() {
        $session = Yii::$app->session;
        $session->set('author-panel.book-dashboard.tab', 'draft');

        $user = Yii::$app->user->identity->id;
        $draft = Book::find()->where(['user_id' => $user])->andWhere(['is_draft' => 1])->all();

        return $this->renderAjax('dashboard/view', [
            'books' => $draft,
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


    public function actionRecycleBin() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $user = Yii::$app->user->identity;

        $recycles = Book::find()->innerJoinWith('recycleBins as bin')->where(['bin.user_id' => $user->id])->all();


        return $this->render('recycle-bin', [
            'recycles' => $recycles,
        ]);
    }
}