<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\_ContentData;
use app\models\Tables\BookCollection;
use app\models\Tables\Collection;
use app\models\Tables\FavoriteBook;
use app\models\Tables\Followers;
use app\models\Tables\FormCreateCollection;
use app\models\Tables\Like;
use app\models\Tables\Read;
use app\models\Tables\ReadLater;
use TPEpubCreator;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;


class InteractionController extends Controller
{
    public function actionLike() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $book = Yii::$app->request->post('book_id');
            $user = Yii::$app->user->identity->id;

            $like = Like::find()->select(['id', 'liked_at'])->where(['book_id' => $book])->andWhere(['user_id' => $user])->one();
            if ($like) {
//                $id = $like->id;
//                $date = $like->liked_at;
                $like->delete();
                return [ 'success' => true, 'is_liked' => false ];
            }
            else {
                $new_like = new Like();
                $new_like->book_id = $book;
                $new_like->user_id = $user;
                $new_like->liked_at = new Expression('NOW()');

                if ($new_like->save()) return ['success' => true, 'is_liked' => true];
                else return ['success' => false, 'is_liked' => false];
            }
        }
        return ['success' => false];
    }

    public function actionRead() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $book = Yii::$app->request->post('book_id');
            $user = Yii::$app->user->identity->id;

            $read = Read::find()->select(['id', 'read_at'])->where(['book_id' => $book])->andWhere(['user_id' => $user])->andWhere(['chapter_id' => null])->one();
            if ($read) {
                $read->delete();
                return ['success' => true, 'is_read' => false];
            }
            else {
                $new_read = new Read();
                $new_read->book_id = $book;
                $new_read->user_id = $user;
                $new_read->chapter_id = null;
                $new_read->read_at = new Expression('NOW()');

                $read_later = ReadLater::find()->where(['book_id' => $book])->andWhere(['user_id' => $user])->one();
                if ($read_later) $read_later->delete();

                if ($new_read->save()) return ['success' => true, 'is_read' => true];
                else return ['success' => false, 'is_read' => false];
            }
        }
        return ['success' => false];
    }

    public function actionReadLater() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $book = Yii::$app->request->post('book_id');
            $user = Yii::$app->user->identity->id;

            $read_later = ReadLater::find()->where(['book_id' => $book])->andWhere(['user_id' => $user])->one();
            if ($read_later) {
                $read_later->delete();
                return ['success' => true, 'is_read_later' => false];
            }
            else {
                $new_read_later = new ReadLater();
                $new_read_later->book_id = $book;
                $new_read_later->user_id = $user;
                $new_read_later->added_at = new Expression('NOW()');

                $read = Read::find()->where(['book_id' => $book])->andWhere(['user_id' => $user])->andWhere(['chapter_id' => null])->one();
                if ($read) $read->delete();

                if ($new_read_later->save()) return ['success' => true, 'is_read_later' => true];
                else return ['success' => true, 'is_read_later' => false];
            }
        }
        return ['success' => false];
    }

    public function actionFavoriteBook() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $book = Yii::$app->request->post('book_id');
            $user = Yii::$app->user->identity->id;

            $favorite = FavoriteBook::find()->select('id')->where(['book_id' => $book])->andWhere(['user_id' => $user])->one();
            if ($favorite) {
                $favorite->delete();
                return ['success' => true, 'is_favorite' => false];
            }
            else {
                $new_favorite = new FavoriteBook();
                $new_favorite->book_id = $book;
                $new_favorite->user_id = $user;
                $new_favorite->added_at = new Expression('NOW()');
                if ($new_favorite->save()) return ['success' => true, 'is_favorite' => true];
                else return ['success' => false, 'is_favorite' => false];
            }
        }
        return ['success' => false];
    }

    public function actionFollowAuthor() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $author = Yii::$app->request->post('author_id');
            $user = Yii::$app->user->identity->id;

            $follow = Followers::find()->select(['id', 'followed_at'])->where(['user_id' => $author])->andWhere(['follower_id' => $user])->one();
            if ($follow) {
                $follow->delete();
                return ['success' => true, 'is_followed' => false];
            }
            else {
                $new_follow = new Followers();
                $new_follow->user_id = $author;
                $new_follow->follower_id = $user;
                $new_follow->followed_at = new Expression('NOW()');
                if ($new_follow->save()) return ['success' => true, 'is_followed' => true];
                else return ['success' => false, 'is_followed' => false];
            }
        }
        return ['success' => false];
    }



    public function actionGetCollections() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->id;
            $collections = Collection::find()->where(['user_id' => $user])->all();

            if ($collections) {
                $data = [];
                foreach ($collections as $collection) {
                    $data[] = [
                        'collection' => $collection,
                        'count' => $collection->getBookCount()
                    ];
                }

                return ['success' => true,'data' => $data];
            }
            else return ['success' => true, 'data' => false];
        }
        return ['success' => false];
    }

    public function actionAddToCollection() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest) {
            $collection_data = Yii::$app->request->post('collection_id');
            preg_match("/\d+/", $collection_data, $collection_id);
            $collection = $collection_id[0];
            $book = Yii::$app->request->post('book_id');

            $book_check = BookCollection::find()->where(['book_id' => $book])->andWhere(['collection_id' => $collection])->one();
            if ($book_check) return [ 'success' => true, 'is_already' => true, 'is_added' => false ];
            else {
                $new_add = new BookCollection();
                $new_add->book_id = $book;
                $new_add->collection_id = $collection;
                if ($new_add->save()) return ['success' => true, 'is_already' => false, 'is_added' => true];
                else return ['success' => true, 'is_already' => false, 'is_added' => false];
            }
        }
        return ['success' => false];
    }

    /*public function  actionRenderCreateCollection() {
        $id = Yii::$app->request->post('book_id');
        $model = new FormCreateCollection();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $collection = new Collection();
            $collection->title = $model->title;
            $collection->user_id = Yii::$app->user->identity->id;
            $collection->created_at = new Expression('NOW()');

            if ($collection->save()) {
                $to_collection = new BookCollection();
                $to_collection->collection_id = $collection->id;
                $to_collection->book_id = $id;
                $to_collection->save();

                return $this->redirect(Url::to(['main/book', 'id' => $id]));
            }
        }

        return $this->renderAjax('//partial/_create_collection', [
            'model' => $model,
        ]);
    }*/

    /*public function actionCreateCollectionAndAdd() {
        //Yii::$app->response->format = Response::FORMAT_JSON;
    }*/

    public function actionCreateCollectionAndAdd() {
        $book_id =  Yii::$app->request->post('book_id');
        $model = new FormCreateCollection();

        if (!Yii::$app->user->isGuest) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $collection = new Collection();
                $collection->user_id = Yii::$app->user->identity->id;
                $collection->title = $model->title;
                $collection->is_private = $model->is_private;
                $collection->created_at = new Expression('NOW()');

                if ($collection->save()) {
                    $add = new BookCollection();
                    $add->book_id = $model->book_id;
                    $add->collection_id = $collection->id;
                    if ($add->save()) return $this->redirect(Url::to(['main/book', 'id' => $model->book_id]));
                }
            }
            return $this->renderAjax('//partial/_create_collection', [
                'model' => $model,
                'book_id' => $book_id,
            ]);
        }
        return $this->goHome();
    }

    public function actionDownloadBook() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('book_id');
        //$id = Yii::$app->request->get('id');
        $book = new _BookData($id);
        $content = new _ContentData($id);


        $epub = new TPEpubCreator();
        $epub->epub_file = $book->title.'.epub';
        $epub->title = $book->title;
        $epub->creator = $book->author->login;
        $epub->language = 'ru';
        $epub->rights = 'Public Domain';

        $begin = "<h1>$book->title</h1>"; $first = true;
        foreach ($content->root as $root) {
            if ($root->is_section) {
                if (array_key_exists($root->id, $content->offspring)) {
                    foreach ($content->offspring[$root->id] as $offspring) {
                        if ($first) {
                            $first = false;
                            $begin .= "<h3>$offspring->title</h3>";

                            $explodes = explode('<tab>', $offspring->content);
                            $implode = '';
                            foreach ($explodes as $explode) $implode .= "<p>$explode</p>";
                            $text = $begin . $implode;
                        }
                        else{
                            $title ="<h3>$offspring->title</h3>";
                            $explodes = explode('<tab>', $offspring->content);
                            $implode = '';
                            foreach ($explodes as $explode) $implode .= "<p>$explode</p>";
                            $text = $title . $implode;
                        }
                        $epub->AddPage($text, false, $offspring->title);
                    }
                }
            }
            else {
                if ($first) {
                    $first = false;
                    $begin .= "<h3>$root->title</h3>";

                    $explodes = explode('<tab>', $root->content);
                    $implode = '';
                    foreach ($explodes as $explode) $implode .= "<p>$explode</p>";
                    $text = $begin . $implode;
                }
                else {
                    $title = "<h3>$root->title</h3>";
                    $explodes = explode('<tab>', $root->content);
                    $implode = '';
                    foreach ($explodes as $explode) $implode .= "<p>$explode</p>";
                    $text = $title . $implode;
                }
                $epub->AddPage($text, false, $root->title);
            }
        }

        $epub->CreateEPUB();
        return ['file' => $epub->epub_file];
        //return Yii::$app->response->sendFile($epub->epub_file)->send();
    }
}