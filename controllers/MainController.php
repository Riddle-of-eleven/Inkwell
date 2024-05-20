<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\_ContentData;
use app\models\Tables\Book;
use app\models\Tables\Chapter;
use app\models\Tables\FavoriteBook;
use app\models\Tables\Followers;
use app\models\Tables\Like;
use app\models\Tables\Read;
use app\models\Tables\ReadLater;
use app\models\Tables\Theme;
use app\models\Tables\User;
use app\models\Tables\ViewHistory;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;


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
        return $this->render('books', [
            'book' => $book,
        ]);
    }

    public function actionRandBook()
    {
        $ids = Book::find()->select('id')->where(['is_draft' => 0])->andWhere(['is_process' => 0])->column();
        $id = array_rand($ids);
        $url = Url::toRoute(['book', 'id' => $ids[$id]]);
        Yii::$app->getResponse()->redirect($url);
    }

    public function actionBook() {
        $id = Yii::$app->request->get('id');
        $test = Book::findOne($id);

        if ($test->is_draft != 0 || $test->is_process != 0) return $this->goHome();
        $book = new _BookData($id);
        $content = new _ContentData($id);

        $like = false; $read = false; $read_later = false; $favorite = false;
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->id;
            $like = Like::find()->select(['id', 'liked_at'])->where(['book_id' => $id])->andWhere(['user_id' => $user])->one();
            $read = Read::find()->select(['id', 'read_at'])->where(['book_id' => $id])->andWhere(['user_id' => $user])->andWhere(['chapter_id' => null])->one();
            $read_later = ReadLater::find()->select(['id', 'added_at'])->where(['book_id' => $id])->andWhere(['user_id' => $user])->one();
            $favorite = FavoriteBook::find()->select('id')->where(['book_id' => $id])->andWhere(['user_id' => $user])->one();


            $view = new ViewHistory();
            $view->user_id = $user;
            $view->book_id = $id;
            $view->view_date = new Expression('CURDATE()');
            $view->view_time = new Expression('CURTIME()');
            $view->user_ip = $_SERVER['REMOTE_ADDR'];
            $view->save();
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

    public function actionReadBook() {
        $id = Yii::$app->request->get('id');
        $query = Chapter::find()->where(['book_id' => $id])->andWhere(['<>', 'is_section', true]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 1]);
        $chapters = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $book = Book::find()->where(['id' => $id])->one();

        return $this->render('read-book', [
            'chapters' => $chapters,
            'pages' => $pages,
            'book' => $book,
        ]);
    }

    public function actionAuthor() {
        $id = Yii::$app->request->get('id');
        $user = User::findOne($id);
        $books = Book::find()->where(['user_id' => $id])->andWhere(['<>', 'is_draft', 1])->andWhere(['<>', 'is_process', 1])->all();

        $book_data = [];
        foreach ($books as $book) {
            $book_data[] = new _BookData($book->id);
        }

        $follow = false;
        if (!Yii::$app->user->isGuest) {
            $follow = Followers::find()->select(['id', 'followed_at'])->where(['user_id' => $id])->andWhere(['follower_id' => Yii::$app->user->identity->id])->one();
        }

        return $this->render('author', [
            'user' => $user,
            'books' => $book_data,
            'follow' => $follow,
        ]);
    }


    public function actionGetThemes() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $themes = Theme::find()->all();
        if ($themes) return ['success' => true, 'data' => $themes];
        else return ['success' => false];
    }
    public function actionChangeTheme() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $theme = Yii::$app->request->post('theme');
        $session = Yii::$app->session;
        $old_theme = $session->get('theme');
        $session->set('theme', $theme);

        return [
            'old_theme' => $old_theme,
            'theme' => $theme
        ];
    }
    public function actionToggleSideMenu() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $is_open = $session->get('is_open');
        if ($is_open == 'open') {
            $session->set('is_open', 'closed');
            return ['is_open' => false];
        }
        else {
            $session->set('is_open', 'open');
            return ['is_open' => true];
        }
    }
}


