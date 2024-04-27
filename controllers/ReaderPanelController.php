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

class ReaderPanelController extends Controller
{
    public function actionLibrary()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();

        $user = Yii::$app->user->identity->id;
        $likes = Like::find()->where(['user_id' => $user])->all();
        $reads = Read::find()->where(['user_id' => $user])->all();
        $reads_later = ReadLater::find()->where(['user_id' => $user])->all();
        $favorites = FavoriteBook::find()->where(['user_id' => $user])->all();

        $liked_books = []; $read_books = []; $read_later_books = []; $favorite_books = [];

        if ($likes)
            foreach ($likes as $like) $liked_books[$like->book_id] = new _BookData($like->book_id);
        if ($reads)
            foreach ($reads as $read) $read_books[$read->book_id] = new _BookData($read->book_id);
        if ($reads_later)
            foreach ($reads_later as $read_later) $read_later_books[$read_later->book_id] = new _BookData($read_later->book_id);
        if ($favorites)
            foreach ($favorites as $favorite) $favorite_books[$favorite->book_id] = new _BookData($favorite->book_id);


        return $this->render('library', [
            'liked_books' => $liked_books,
            'read_books' => $read_books,
            'read_later_books' => $read_later_books,
            'favorite_books' => $favorite_books,
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