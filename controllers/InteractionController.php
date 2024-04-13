<?php

namespace app\controllers;

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

            $favorite =
        }
        return ['success' => false];
    }
}