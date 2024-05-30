<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\Tables\FavoriteBook;
use app\models\Tables\Followers;
use app\models\Tables\Like;
use app\models\Tables\Read;
use app\models\Tables\ReadLater;
use app\models\Tables\User;
use app\models\Tables\ViewHistory;
use Yii;
use yii\web\Controller;
use app\models\Tables\Book;

class ReaderPanelController extends Controller
{
    public function actionLibrary()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $user = Yii::$app->user->identity;

        /*$likes = Book::find()->innerJoinWith('likes')->where(['like.user_id' => $user->id])->all();
        $reads = Book::find()->innerJoinWith('likes')->where(['like.user_id' => $user->id])->all();
        $laters = Book::find()->innerJoinWith('likes')->where(['like.user_id' => $user->id])->all();
        $favorites = Book::find()->innerJoinWith('likes')->where(['like.user_id' => $user->id])->all();*/

        $session = Yii::$app->session;
        $tab = $session->has('reader.library.tab') ? $session->get('reader.library.tab') : 'likes';

        return $this->render('library/library', [
            /*'likes' => $likes,
            'reads' => $reads,
            'laters' => $laters,
            'favorites' => $favorites,*/
            'tab' => $tab
        ]);
    }
    public function actionLoadLikes() {
        $user = Yii::$app->user->identity;
        $session = Yii::$app->session;
        $session->set('reader.library.tab', 'likes');
        $books = Book::find()->innerJoinWith('likes')->where(['like.user_id' => $user->id])->all();
        return $this->renderAjax('library/view', [
            'books' => $books,
            'interaction' => 'like',
        ]);
    }
    public function actionLoadFavorites() {
        $user = Yii::$app->user->identity;
        $session = Yii::$app->session;
        $session->set('reader.library.tab', 'favorites');
        $books = Book::find()->innerJoinWith('favoriteBooks f')->where(['f.user_id' => $user->id])->all();
        return $this->renderAjax('library/view', [
            'books' => $books,
            'interaction' => 'favorite',
        ]);
    }
    public function actionLoadReads() {
        $user = Yii::$app->user->identity;
        $session = Yii::$app->session;
        $session->set('reader.library.tab', 'reads');
        $books = Book::find()->innerJoinWith('reads')->where(['read.user_id' => $user->id])->all();
        return $this->renderAjax('library/view', [
            'books' => $books,
            'interaction' => 'read',
        ]);
    }
    public function actionLoadLaters() {
        $user = Yii::$app->user->identity;
        $session = Yii::$app->session;
        $session->set('reader.library.tab', 'laters');
        $books = Book::find()->innerJoinWith('readLaters r')->where(['r.user_id' => $user->id])->all();
        return $this->renderAjax('library/view', [
            'books' => $books,
            'interaction' => 'later',
        ]);
    }

    public function actionCollections()
    {

    }

    public function actionFollowedAuthors() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $id = Yii::$app->user->identity->id;
        $follows = Followers::find()->select(['user_id', 'followed_at'])->where(['follower_id' => $id])->all();
        $authors = [];
        if ($follows)
            foreach ($follows as $follow) {
                $authors[] = User::findOne($follow->user_id);
            }
        //$authors = User::find()->where([''])

        return $this->render('followed-authors', [
            'follows' => $authors
        ]);
    }

    public function actionViewHistory() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $views = ViewHistory::find()->select(['id', 'book_id', 'view_date', 'view_time'])->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['view_date' => SORT_DESC])->all();
        $v = [];
        if ($views) {
            /*foreach ($views as $view) {
                $formatter = new Formatter();
                $date = $formatter->asDate($view->viewed_at, 'short');
                if (!array_key_exists($date, $viewed_books))
                    $viewed_books[$date] = [
                        $view->book_id => [$formatter->asTime($view->viewed_at, 'short')]
                    ];
                else {
                    if (!array_key_exists($view->book_id, $viewed_books[$date]))
                        $viewed_books[$date] = [
                            $view->book_id => [$formatter->asTime($view->viewed_at, 'short')]
                        ];
                    else $viewed_books[$date][$view->book_id][] = $formatter->asTime($view->viewed_at, 'short');
                }
            }
            VarDumper::dump($viewed_books, 10, true); die;*/

            foreach ($views as $view) {
                $date = $view->view_date; $time = $view->view_time; $id = $view->book_id;
                if (!array_key_exists($date, $v)) $v[$date] = [$id => [$time]];
                else {
                    if (!array_key_exists($id, $v[$date])) $v[$date][$id] = [$time];
                    else $v[$date][$id][$time] = $time;
                }
            }
        }


        return $this->render('view-history', [
            'views' => $v,
        ]);
    }
}