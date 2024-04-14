<?php

namespace app\controllers;

use app\models\BookCollection;
use app\models\Collection;
use app\models\FavoriteBook;
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

                if ($new_read->save()) return ['success' => true, 'is_read' => true];
                else return ['success' => false, 'is_read' => false];
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
}