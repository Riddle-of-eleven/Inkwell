<?php

namespace app\controllers\author;

use app\models\CreateBookForms\FormCreateChapter;
use app\models\CreateBookForms\FormCreateCover;
use app\models\CreateBookForms\FormCreateFandom;
use app\models\CreateBookForms\FormCreateFromFile;
use app\models\CreateBookForms\FormCreateMain;
use app\models\Tables\Book;
use app\models\Tables\BookFandom;
use app\models\Tables\BookGenre;
use app\models\Tables\Chapter;
use app\models\Tables\Fandom;
use app\models\Tables\Genre;
use app\models\Tables\Rating;
use app\models\Tables\Relation;
use app\models\Tables\Size;
use app\models\Tables\Tag;
use app\models\Tables\Type;
use SimpleXMLElement;
use Yii;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use ZipArchive;

class CreateBookController extends Controller
{
    public function actionFindGenres() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        /*$input = Yii::$app->request->post('input');
        $selected_genres = Yii::$app->request->post('selected_genres');

        if ($input) $genres = Genre::find()->where(['like', 'title', $input]);
        else $genres = Genre::find();

        if ($selected_genres)
            foreach ($selected_genres as $selected_genre) {
                $genres->andWhere(['<>', 'id', $selected_genre]);
            }
        $find_genres = $genres->all();

        foreach ($find_genres as $key => $value) {
            $data[$key] = $value;
        }*/
        return $this->findMeta(
            Yii::$app->request->post('input'),
            Yii::$app->request->post('selected_genres'),
            Genre::class
        );
    }
    public function actionFindTags() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->findMeta(
            Yii::$app->request->post('input'),
            Yii::$app->request->post('selected_tags'),
            Tag::class
        );
    }
    public function actionFindFandoms() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->findMeta(
            Yii::$app->request->post('input'),
            Yii::$app->request->post('selected_fandoms'),
            Fandom::class
        );
        /*$input = Yii::$app->request->post('input');

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

        return $data;*/
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

        //$genres = Genre::find();

        $model_genres = [];
        $model_tags = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //VarDumper::dump($model, 10, true);
            if ($model->genres)
                foreach ($model->genres as $genre) {
                    $model_genres[] = Genre::findOne($genre);
                }
            if ($model->tags)
                foreach ($model->tags as $tag) {
                    $model_tags[] = Tag::findOne($tag);
                }
        }

        /*if ($model->load(Yii::$app->request->post()) && $model->validate()) {
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
        }*/

        return $this->render('create-main', [
            'model'=> $model,
            'model_genres' => $model_genres,
            'model_tags' => $model_tags,

            'relations' => $relations,
            'ratings' => $ratings,
            'plan_sizes' => $plan_sizes,
        ]);
    }

    public function actionCreateFandom()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();

        $model = new FormCreateFandom();
        $types = Type::getTypesList();
        $id = Yii::$app->request->get('id');


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //VarDumper::dump($model, 10, true); die;
            if ($model->type == 2)
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
            //VarDumper::dump($model->cover, 10, true); die;
            if ($model->cover) {
                $model->cover = UploadedFile::getInstance($model, 'cover');
                if ($path = $model->upload()) {
                    $book = Book::findOne($id);
                    $book->cover = $path;

                    $book->is_process = 0;
                    $book->step = 0;

                    $book->save();
                }
            }

            $book = Book::findOne($id);
            $book->is_process = 0;
            $book->step = 0;
            $book->save();
            return $this->redirect(['/author/author-panel/books-dashboard', 'id' => $id]);
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

            if ($chapter->save()) {
                $this_book = Book::findOne($book);
                $this_book->is_draft = 0;
                $this_book->save();
                return $this->redirect(['/main/book', 'id' => $book]);
            }
        }

        return $this->render('create-chapter', [
            'model' => $model,
        ]);
    }

    public function actionCreateChapterFile() {
        if (Yii::$app->user->isGuest) return $this->goHome();
        $book = Yii::$app->request->get('id');
        $model = new FormCreateFromFile();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $path = 'chapter-files/'. $model->file->baseName . '.' . $model->file->extension;
            $model->file->saveAs($path);


            $file = fopen($path, 'r');
            $metadata = stream_get_meta_data($file);
            $pathInfo = pathinfo($metadata['uri']);
            $fileName = $pathInfo['filename'];
            $dirName = $pathInfo['dirname'];
            fclose($file);

            //VarDumper::dump($pathInfo, 10, true); die;

            if (!is_dir($dirName.'/'.$fileName)) {
                $zip = new ZipArchive();
                if ($zip->open($dirName.'/'.$pathInfo['basename']) === true) {
                    $zip->extractTo($dirName.'/'.$fileName);
                    $zip->close();
                }
            }

            $xml = file_get_contents($dirName.'/'.$fileName.'/word/document.xml');
            $simple = new SimpleXMLElement($xml);

            // ссылка в кавычках — это адрес пространства имён w, под которым идут все элементы в файле
            $content = $simple->children('http://schemas.openxmlformats.org/wordprocessingml/2006/main');

            $text = '';
            foreach ($content->body->p as $element) {
                $text .= '<tab>';
                foreach ($element->r as $run) {
                    if ($run->rPr->b && $run->rPr->i) $text .= "<b><i>$run->t</i></b>";
                    else if ($run->rPr->b) $text .= "<b>$run->t</b>";
                    else if ($run->rPr->i) $text .= "<i>$run->t</i>";
                    else $text .= $run->t;
                }
            }

            /*VarDumper::dump(Yii::$app->request->post('FormCreateFromFile')['title']);
            die;*/

            $chapter = new Chapter();
            $chapter->book_id = $book;
            $chapter->created_at = new Expression('NOW()');
            $chapter->title = Yii::$app->request->post('FormCreateFromFile')['title'];
            $chapter->is_draft = 0;
            $chapter->is_section = 0;
            $chapter->parent_id = null;
            $chapter->content = $text;
            if ($chapter->save()) {
                $this_book = Book::findOne($book);
                $this_book->is_draft = 0;
                $this_book->save();

                $this->redirect(['main/book', 'id' => $book]);
            }

            unlink($dirName.'/'.$pathInfo['basename']);
            $this->deleteFolder($dirName.'/'.$fileName);

        }

        return $this->render('create-chapter-file', [
            'model' => $model,
        ]);
    }

    /*public function actionCreateAccess()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();
        return $this->render('create-access');
    }*/



    // вспомогательные функции
    public function deleteFolder($folderPath) {
        if (!is_dir($folderPath)) return false;

        $files = array_diff(scandir($folderPath), array('.', '..'));
        foreach ($files as $file) {
            $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) $this->deleteFolder($filePath);
            else unlink($filePath);
        }

        return rmdir($folderPath);
    }

    public function findMeta($input, $selected, $model): array
    {
        $data = [];
        // экранировать потом весь этот input
        if ($input) $metas = $model::find()->where(['like', 'title', $input]);
        else $metas = $model::find();

        if ($selected)
            foreach ($selected as $item) {
                $metas->andWhere(['<>', 'id', $item]);
            }
        $find_metas = $metas->all();
        foreach ($find_metas as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }
}