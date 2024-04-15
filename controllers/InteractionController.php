<?php

namespace app\controllers;

use app\models\BookCollection;
use app\models\Collection;
use app\models\FavoriteBook;
use app\models\FormCreateCollection;
use app\models\ReadLater;
use app\models\User;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\Response;
use app\models\Like;
use app\models\Read;

use yii\helpers\VarDumper;

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

            $favorite =FavoriteBook::find()->select('id')->where(['book_id' => $book])->andWhere(['user_id' => $user])->one();
            if ($favorite) {
                $favorite->delete();
                return ['success' => true, 'is_favorite' => false];
            }
            else {
                $new_favorite = new FavoriteBook();
                $new_favorite->book_id = $book;
                $new_favorite->user_id = $user;
                if ($new_favorite->save()) return ['success' => true, 'is_favorite' => true];
                else return ['success' => false, 'is_favorite' => false];
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
        $model = new FormCreateCollection();
        return $this->renderAjax('//partial/_create_collection', [
            'model' => $model,
        ]);
    }*/

    public function actionCreateCollectionAndAdd() {
        $model = new FormCreateCollection();

        //if ($model->book_id) $model->book_id = Yii::$app->request->post('book_id');
        $book_id =  Yii::$app->request->post('book_id');
        //VarDumper::dump($model, 10, true);
        if (!Yii::$app->user->isGuest) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                VarDumper::dump(Yii::$app->request->post(), 10, true);
                die;
                $collection = new Collection();
                $collection->user_id = Yii::$app->user->identity->id;
                $collection->title = $model->title;
                $collection->is_private = $model->is_private;
                $collection->created_at = new Expression('NOW()');

                if ($collection->save()) {
                    $add = new BookCollection();
                    $add->book_id = Yii::$app->request->post('book_id');
                    $add->collection_id = $collection->id;
                    if ($add->save()) return $this->goHome();
                }
            }
            return $this->renderAjax('//partial/_create_collection', [
                'model' => $model,
                'book_id' => $book_id,
            ]);
        }
        return $this->goHome();
    }
}