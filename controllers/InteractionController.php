<?php

namespace app\controllers;

use app\models\_BookData;
use app\models\_ContentData;
use app\models\Forms\FormCreateCollection;
use app\models\Tables\Award;
use app\models\Tables\Book;
use app\models\Tables\BookCollection;
use app\models\Tables\Chapter;
use app\models\Tables\Collection;
use app\models\Tables\FavoriteBook;
use app\models\Tables\Followers;
use app\models\Tables\Like;
use app\models\Tables\Read;
use app\models\Tables\ReadLater;
use app\models\Tables\User;
use DOMDocument;
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
                return ['success' => true, 'is_liked' => false];
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

    public function actionAward() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->is_moderator) {
            $book = Yii::$app->request->post('book_id');
            $user = Yii::$app->user->identity->id;

            $awarded = Award::find()->select('id')->where(['book_id' => $book])->andWhere(['moderator_id' => $user])->one();
            if ($awarded) {
                $awarded->delete();
                return ['success' => true, 'is_awarded' => false];
            }
            else {
                $new_awarded = new Award();
                $new_awarded->book_id = $book;
                $new_awarded->moderator_id = $user;
                $new_awarded->awarded_at = new Expression('NOW()');
                if ($new_awarded->save()) return ['success' => true, 'is_awarded' => true];
                else return ['success' => false, 'is_awarded' => false];
            }
        }
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


    public function actionBanUser() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->user->isGuest)
            if (Yii::$app->user->identity->is_moderator == 1) {
                $moderator = Yii::$app->user;
                $user_id = Yii::$app->request->post('user');
                $time = Yii::$app->request->post('time');
                $reason = Yii::$app->request->post('reason');

                $user = User::findOne($user_id);
                $user->is_banned = 1;

                if ($time != 5) {
                    $until = '3 days';
                    if ($time == 2) $until = '1 week';
                    else if ($time == 3) $until = '1 month';
                    else if ($time == 4) $until = '1 year';
                    $user->banned_until = date('Y-m-d H:i:s', strtotime("+$until"));
                }

                $user->ban_reason_id = $reason;
                $user->ban_moderator_id = $moderator->identity->id;

                //return $user->banned_until;

                if ($user->save()) return ['success' => true, 'is_banned' => true];
                else return ['success' => true, 'is_banned' => false];
            }
        else return ['success' => false, 'is_banned' => false];
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
        $format = Yii::$app->request->post('format');
        $book = Book::findOne($id);

        if ($format == 'epub') {
            $epub = new TPEpubCreator();
            $epub->epub_file = $book->title.'.epub';
            $epub->title = $book->title;
            $epub->creator = $book->user->login;
            $epub->language = 'ru';
            $epub->rights = 'Public Domain';

            $content = "<h1>$book->title</h1>";
            $content .= "<p>Автор: " . $book->user->login . "</p>";
            $content .= "<p>Загружено с <a href='https://inkwell/web/'>Inkwell</a></p>";

            $epub->AddPage($content, false, 'Титульная страница');

            $roots = Chapter::find()->where(['book_id' => $id])->andWhere(['parent_id' => null])->andWhere(['is_draft' => 0])->all();
            foreach ($roots as $root) {
                $content = '';
                if ($root->is_section == 1) {
                    $content .= "<h2>$root->title</h2>";
                    $first = Chapter::find()->where(['parent_id' => $root->id])->andWhere(['previous_id' => null])->one();
                    if ($first) {
                        $content .= "<h3>$first->title</h3>$first->content";
                        $epub->AddPage($content, false, $first->title);
                        $content = '';

                        $next = true;
                        $previous = $first->id;
                        while ($next) {
                            $element = Chapter::find()->where(['previous_id' => $previous])->one();
                            if ($element) {
                                $content .= "<h3>$element->title</h3>$element->content";
                                $epub->AddPage($content, false, $element->title);
                                $content = '';
                                $previous = $element->id;
                                $next = true;
                            } else $next = false;
                        }
                    }
                }
                else {
                    $content .= "<h3>$root->title</h3>$root->content";
                    $epub->AddPage($content, false, $root->title);
                }
            }

            $epub->CreateEPUB();
            return ['file' => $epub->epub_file];
        }
        else if ($format == 'fb2') {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->formatOutput = true;

            $fb2 = $dom->createElement('FictionBook');
            $fb2->setAttribute('xmlns', 'http://www.gribuser.ru/xml/fictionbook/2.0');
            $fb2->setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');

            $description = $dom->createElement('description');

            $titleInfo = $dom->createElement('title-info');
            $titleInfo->appendChild($dom->createElement('book-title', $book->title)); // название
            $titleInfo->appendChild($dom->createElement('author', $book->user->login)); // автор

            $description->appendChild($titleInfo);
            $fb2->appendChild($description);

            $body = $dom->createElement('body');

            $roots = Chapter::find()->where(['book_id' => $id])->andWhere(['parent_id' => null])->andWhere(['is_draft' => 0])->all();
            foreach ($roots as $root) {
                $content = '';
                if ($root->is_section == 1) {
                    //$content .= "<h2>$root->title</h2>";
                    $first = Chapter::find()->where(['parent_id' => $root->id])->andWhere(['previous_id' => null])->one();
                    if ($first) {
                        $this->appendToSection($first->content, $first->title, $dom, $body);
                        $next = true;
                        $previous = $first->id;
                        while ($next) {
                            $element = Chapter::find()->where(['previous_id' => $previous])->one();
                            if ($element) {
                                $this->appendToSection($element->content, $element->title, $dom, $body);
                                $content = '';
                                $previous = $element->id;
                                $next = true;
                            } else $next = false;
                        }
                    }
                }
                else {
                    $this->appendToSection($root->content, $root->title, $dom, $body);
                }
            }

            $fb2->appendChild($body);
            $dom->appendChild($fb2);
            $dom->save('generated_files/' . $book->title . '.fb2');
            return ['file' => 'generated_files/' . $book->title . '.fb2'];
        }
    }

    public function appendToSection($content, $name, $dom, $body) {
        $section = $dom->createElement('section');
        $title = $dom->createElement('title');
        $title->appendChild($dom->createElement('p', $name));
        $section->appendChild($title);

        // создание временного DOM
        $tempDom = new DOMDocument();
        libxml_use_internal_errors(true);
        $tempDom->loadHTML('<?xml encoding="UTF-8">' . $content);
        libxml_clear_errors();

        // импорт в основной DOM
        $html = $tempDom->getElementsByTagName('body')->item(0);
        foreach ($html->childNodes as $child) {
            $importedNode = $dom->importNode($child, true);
            $section->appendChild($importedNode);
        }

        $body->appendChild($section);
    }
}