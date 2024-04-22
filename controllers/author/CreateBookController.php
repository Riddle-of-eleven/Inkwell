<?php

namespace app\controllers\author;

use app\models\Book;
use app\models\BookFandom;
use app\models\BookGenre;
use app\models\Chapter;
use app\models\CreateBookForms\FormCreateChapter;
use app\models\CreateBookForms\FormCreateCover;
use app\models\CreateBookForms\FormCreateFandom;
use app\models\CreateBookForms\FormCreateMain;
use app\models\Fandom;
use app\models\Genre;
use app\models\Rating;
use app\models\Relation;
use app\models\Size;
use app\models\Type;
use yii\helpers\Url;
use Yii;
use yii\db\Expression;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class CreateBookController extends Controller
{
    public function actionFindGenres() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $input = Yii::$app->request->post('input');

        // экранировать потом это дело
        if ($input) {
            $genres = Genre::find()->where(['like', 'title', $input])->all();
            foreach ($genres as $genre) {
                $data[$genre->id] = $genre->title;
            }
        }
        else {
            $genres = Genre::getGenresList();
            foreach ($genres as $key => $genre) {
                $data[$key] = $genre;
            }
        }

        return $data;
    }
    public function actionFindFandoms() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $input = Yii::$app->request->post('input');

        if ($input) {
            $fandoms = Fandom::find()->where(['like', 'title', $input])->all();
            foreach ($fandoms as $fandom) {
                $data[$fandom->id] = $fandom->title;
            }
        }
        else {
            $fandoms = Fandom::getFandomsList();
            foreach ($fandoms as $key => $fandom) {
                $data[$key] = $fandom;
            }
        }

        return $data;
    }

    public function actionCreateMain()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();

        /*$session = Yii::$app->session;
        if ($session->isActive) {
            $id = $session->get('id');
        }

        $session->open();*/

        $model = new FormCreateMain();
        $relations = Relation::getRelationsList();
        $ratings = Rating::getRatingsList();
        $plan_sizes = Size::getSizesList();
        $genres = Genre::getGenresList();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /*VarDumper::dump($model, 10, true);
            die;*/
            $process = new Book();
            $process->user_id = Yii::$app->user->identity->id;
            $process->created_at = new Expression('NOW()');
            $process->is_draft = 1;

            $process->title = $model->title;
            $process->description = $model->description;
            $process->remark = $model->remark;
            $process->dedication = $model->dedication;
            $process->disclaimer = $model->disclaimer;

            $process->rating_id = $model->rating;
            $process->plan_size_id = $model->plan_size;
            $process->relation_id = $model->relation;

            $process->is_process = 1;
            $process->step = 1;

            if ($process->save()) {
                foreach ($model->genres as $genre) {
                    $process_book_genre = new BookGenre();
                    $process_book_genre->book_id = $process->id;
                    $process_book_genre->genre_id = $genre;
                    $process_book_genre->save();
                }

                return $this->redirect(Url::to(['create-fandom', 'id' => $process->id]));
            }
        }

        return $this->render('create-main', [
            'model'=> $model,
            'relations' => $relations,
            'ratings' => $ratings,
            'plan_sizes' => $plan_sizes,
            'genres' => $genres,
        ]);
    }

    public function actionCreateFandom()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();

        $model = new FormCreateFandom();
        $types = Type::getTypesList();
        $id = Yii::$app->request->get('id');


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->fandoms as $fandom) {
                $process_book_fandom = new BookFandom();
                $process_book_fandom->book_id = $id;
                $process_book_fandom->fandom_id = $fandom;
                $process_book_fandom->save();
            }
            $book = Book::findOne($id);
            $book->type_id = $model->type;
            $book->step = 2;
            $book->completeness_id = 1;
            $book->real_size_id = 1;
            $book->save();

            return $this->redirect(Url::to(['create-cover', 'id' => $id]));
        }

        return $this->render('create-fandom', [
            'model' => $model,
            'types' => $types,
        ]);
    }

    public function actionCreateCover()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $model = new FormCreateCover();
        $id = Yii::$app->request->get('id');

        if (Yii::$app->request->isPost) {
            $model->cover = UploadedFile::getInstance($model, 'cover');
            if ($path = $model->upload()) {
                $book = Book::findOne($id);
                $book->cover = $path;

                $book->is_process = 0;
                $book->step = 0;

                $book->save();

                return $this->redirect(['/author/author-panel/books-dashboard', 'id' => $id]);
            }
        }

        return $this->render('create-cover', [
            'model' => $model,
        ]);
    }

    public function actionCreateChapter() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $book = Yii::$app->request->get('id');
        $model = new FormCreateChapter();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $chapter = new Chapter();
            $chapter->book_id = $book;
            $chapter->title = $model->title;
            $chapter->created_at = new Expression('NOW()');
            $chapter->content = $model->content;
            $chapter->parent_id = null;

            if ($chapter->save()) return $this->redirect(['/main/book', 'id' => $book]);
        }

        return $this->render('create-chapter', [
            'model' => $model,
        ]);
    }

    /*public function actionCreateAccess()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('create-access');
    }*/
}