<?php

namespace app\controllers\author;

use app\models\_ContentData;
use app\models\Tables\Book;
use app\models\Tables\Chapter;
use app\models\Tables\Completeness;
use app\models\Tables\PublicEditing;
use app\models\Tables\RecycleBin;
use SimpleXMLElement;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use ZipArchive;

class ModifyController extends Controller
{
    public function actionBook() {
        $session = Yii::$app->session;
        $tab = $session->has('modify.book.tab') ? $session->get('modify.book.tab') : 'main';
        $book = $session->has('modify.book') ? $session->get('modify.book') : null;

        if (!$book) return $this->goHome();
        $this_book = Book::findOne($book);

        return $this->render('book', [
            'tab' => $tab,
            'book' => $this_book
        ]);
    }
    public function actionDefineModify($book) {
        $session = Yii::$app->session;
        if (!$book) return $this->goHome();
        $session->set('modify.book', $book);
        return $this->redirect(Url::to(['author/modify/book']));
    }


    public function actionLoadMain() {
        $session = Yii::$app->session;
        $session->set('modify.book.tab', 'main');

        $book = Book::findOne($session->get('modify.book'));
        $modify_title = $book->title;
        $modify_description = $book->description;
        $modify_remark = $book->remark;
        $modify_disclaimer = $book->disclaimer;
        $modify_dedication = $book->dedication;



        return $this->renderAjax('tabs/main', [
            'book' => $book,

            // данные для изменения
            'modify_title' => $modify_title,
            'modify_description' => $modify_description,
            'modify_remark' => $modify_remark,
            'modify_disclaimer' => $modify_disclaimer,
            'modify_dedication' => $modify_dedication,
        ]);
    }

    public function actionLoadChapters() {
        $session = Yii::$app->session;
        $session->set('modify.book.tab', 'chapters');

        $book = Book::findOne($session->get('modify.book'));
        $roots = Chapter::find()->where(['book_id' => $book->id, 'parent_id' => null])->orderBy('order')->all();
        $leaves = [];
        if ($roots)
            foreach ($roots as $root) {
                $leaves[$root->id] = Chapter::find()->where(['book_id' => $book->id, 'parent_id' => $root->id])->orderBy('order')->all();
            }

        return $this->renderAjax('tabs/chapters', [
            'book' => $book,
            'roots' => $roots,
            'leaves' => $leaves,
        ]);
    }

    public function actionLoadAccess() {
        $session = Yii::$app->session;
        $session->set('modify.book.tab', 'access');

        $book = Book::findOne($session->get('modify.book'));
        $public_editing = PublicEditing::find()->all();
        $statuses = Completeness::find()->all();

        $this_public_editing = $book->public_editing_id;
        $this_status = $book->completeness_id;

        return $this->renderAjax('tabs/access', [
            'book' => $book,
            'public_editing' => $public_editing,
            'statuses' => $statuses,

            'this_public_editing' => $this_public_editing,
            'this_status' => $this_status,
        ]);
    }


    public function actionDeleteBook() {
        $session = Yii::$app->session;
        $book = Book::findOne($session->get('modify.book'));
        $user = Yii::$app->user->identity;

        if ($book)
            if ($book->user_id == $user->id) {
                //if ($book->delete()) return $this->redirect(Url::to(['author/author-panel/books-dashboard']));
                $recycle = new RecycleBin();
                $recycle->book_id = $book->id;
                $recycle->user_id = $user->id;
                $recycle->deleted_at = new Expression('NOW()');
                $recycle->days_stored = 30;
                if ($recycle->save()) return $this->redirect(Url::to(['author/author-panel/books-dashboard']));
            }
    }


    public function actionSetAccess() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $user = Yii::$app->user->identity;

        $draft = Yii::$app->request->post('draft');
        $status = Yii::$app->request->post('status');
        $editing = Yii::$app->request->post('editing');
        $book = Book::findOne($session->get('modify.book'));

        if ($book)
            if ($book->user_id == $user->id) {
                if ($draft == 1 || $draft == 0) $book->is_draft = $draft;
                if ($status) $book->completeness_id = $status;
                if ($editing) $book->public_editing_id = $editing;

                if ($book->save()) return ['success' => true, 'is_draft' => $book->is_draft];
                else return ['success' => false, 'is_draft' => $book->is_draft];
            }
        return ['success' => false, 'is_draft' => $book->is_draft];
    }

    public function actionAddChapter() {
        $session = Yii::$app->session;
        $book = $session->has('modify.book') ? $session->get('modify.book') : null;
        if (!$book) return $this->goHome();
        $this_book = Book::findOne($book);

        // данные, введённые пользователем
        $chapter_title = $session->get('modify.create-chapter.title');
        $chapter_type = $session->get('modify.create-chapter.type');
        $chapter_text = $session->get('modify.create-chapter.text');

        $chapter_section_position = $session->get('modify.create-chapter.section_position');
        $chapter_chapter_position = $session->get('modify.create-chapter.chapter_position');

        // объективные данные
        $sections = Chapter::find()->where(['book_id' => $this_book->id])->andWhere(['is_section' => 1])->all();
        $chapters = Chapter::find()->where(['book_id' => $this_book->id])->andWhere(['parent_id' => $chapter_section_position != '0' ? $chapter_section_position : null])->all();

        if (!$sections) $session->remove('modify.create-chapter.section_position');
        if (!$chapters) $session->remove('modify.create-chapter.chapter_position');


        return $this->render('add-chapter', [
            'book' => $this_book,
            'chapter_title' => $chapter_title,
            'chapter_type' => $chapter_type,
            'chapter_text' => $chapter_text,

            'chapter_section_position' => $chapter_section_position,
            'chapter_chapter_position' => $chapter_chapter_position,

            'chapters' => $chapters,
            'sections' => $sections,
        ]);
    }
    public function actionDeleteChapter() {
        $session = Yii::$app->session;
        $session->remove('modify.create-chapter.title');
        $session->remove('modify.create-chapter.type');
        $session->remove('modify.create-chapter.text');
        $session->remove('modify.create-chapter.section_position');
        $session->remove('modify.create-chapter.chapter_position');
        return $this->redirect(Url::to(['author/modify/book']));
    }
    public function actionSaveChapter() {
        $session = Yii::$app->session;
        $title = $session->get('modify.create-chapter.title');
        $type = $session->get('modify.create-chapter.type');
        $text = $session->get('modify.create-chapter.text');
        $section_position = $session->get('modify.create-chapter.section_position');
        $chapter_position = $session->get('modify.create-chapter.chapter_position');

        $book = $session->has('modify.book') ? $session->get('modify.book') : null;

        if ($book && $title && $type) {
            $chapter = new Chapter();
            $chapter->book_id = $book;
            $chapter->created_at = new Expression('NOW()');
            $chapter->title = $title;
            $chapter->is_draft = 0;
            $chapter->is_section = $type == 'section' ? 1 : 0;
            $chapter->parent_id = $section_position;
            $chapter->previous_id = $chapter_position;
            $chapter->content = $text;

            if ($chapter->save()) {
                $session->remove('modify.create-chapter.title');
                $session->remove('modify.create-chapter.type');
                $session->remove('modify.create-chapter.text');
                $session->remove('modify.create-chapter.section_position');
                $session->remove('modify.create-chapter.chapter_position');
                return $this->redirect(Url::to(['author/modify/book']));
            }
        }
        return $this->goBack();
    }


    public function actionSaveChapterData() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $session_key = Yii::$app->request->post('session_key');
        $data = Yii::$app->request->post('data');
        $session->set('modify.create-chapter.' . $session_key, $data);
        $book = $session->has('modify.book') ? $session->get('modify.book') : null;

        if ($session_key == 'section_position' && $book) {
            $parent = $data != '0' ? $data : null;
            $session->remove('modify.create-chapter.chapter_position');
            return ['chapters' => Chapter::find()->where(['book_id' => $book])->andWhere(['parent_id' => $parent])->all()];
        }

        if ($session_key == 'type' && $data == 'section') {
            $session->remove('modify.create-chapter.text');
        }
    }


    public function actionProcessFile() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $fileName = uniqid() . '.' . $file->extension;
            $path = 'uploaded_files/' . $fileName;
            if ($file->saveAs($path)) {
                $content = false;
                if ($file->extension == 'odt') $content = $this->processODT($fileName);
                else if ($file->extension == 'docx') $content = $this->processDOCX($fileName);
                Yii::$app->session->set('modify.create-chapter.text', $content);
                return $content;
            }
        }
        return false;
    }

    public function processODT($fileName) {
        $directory = $this->extractText($fileName);
        // получение содержимого
        if (file_exists('uploaded_files/' . $directory . '/content.xml')) {
            $xml = file_get_contents('uploaded_files/' . $directory . '/content.xml');
            $simple = new SimpleXMLElement($xml);

            // пространства имён
            $ns_office = 'urn:oasis:names:tc:opendocument:xmlns:office:1.0';
            $ns_styles = 'urn:oasis:names:tc:opendocument:xmlns:style:1.0';

            $simple->registerXPathNamespace("office", $ns_office);
            $simple->registerXPathNamespace("style", $ns_styles);

            $styles = [];
            $names = $simple->xpath('//office:automatic-styles/style:style/@style:name');

            foreach ($names as $name) {
                $title = (string) $name;
                if (strpos($title, 'P') !== false) {
                    $paragraph_attributes = $simple->xpath("//office:automatic-styles/style:style[@style:name='$title']/style:paragraph-properties");
                    $text_align = $paragraph_attributes ? (string) $paragraph_attributes[0]->attributes('fo', true)->{'text-align'} : null;
                    if ($text_align == 'justify') $text_align = null;
                    $styles['p'][$title] = [
                        'text-align' => $text_align
                    ];
                }

                else if (strpos($title, 'T') !== false) {
                    $text_attributes = $simple->xpath("//office:automatic-styles/style:style[@style:name='$title']/style:text-properties");
                    $font_weight = $text_attributes ? (string)$text_attributes[0]->attributes('fo', true)->{'font-weight'} : null;
                    $font_style = $text_attributes ? (string)$text_attributes[0]->attributes('fo', true)->{'font-style'} : null;
                    $styles['t'][$title] = [
                        'font-weight' => $font_weight,
                        'font-style' => $font_style,
                    ];
                }
            }

            $entries = [];
            $texts = $simple->xpath("//office:body/office:text//text:p");
            foreach ($texts as $text) {
                $entry = $text->asXML();
                $entry_style = $text->attributes('text', true)->{'style-name'};
                preg_match_all('/<text:p.*?>(.*?)<\/text:p>/s', $entry, $matches);
                $inner_text = $matches[1][0] ?? '';

                if (isset($styles['t']))
                foreach ($styles['t'] as $key => $value) {
                    $font_weight = $value['font-weight'];
                    $font_style = $value['font-style'];
                    $start = ''; $end = '';
                    if ($font_weight) {
                        $start .= '<strong>';
                        $end .= '</strong>';
                    }
                    if ($font_style) {
                        $start .= '<em>';
                        $end = '</em>' . $end;
                    }
                    $inner_text = preg_replace('/<text:span[^>]+text:style-name="'. $key .'"[^>]*>(.*?)<\/text:span>/', $start . '$1' . $end, $inner_text);
                }

                if ($styles['p'][(string)$entry_style]['text-align'] == 'center') $class = "class='ql-align-center'";
                else if ($styles['p'][(string)$entry_style]['text-align'] == 'end') $class = "class='ql-align-right'";
                else $class = null;

                $entries[] = "<p $class>$inner_text</p>";
            }

            $this->deleteFolder('uploaded_files/' . $directory);
            return implode($entries);
        }
    }
    public function processDOCX($fileName) {
        $directory = $this->extractText($fileName);
        if (file_exists('uploaded_files/' . $directory . '/word/document.xml')) {
            $xml = file_get_contents('uploaded_files/' . $directory . '/word/document.xml');
            $simple = new SimpleXMLElement($xml);

            // ссылка в кавычках — это адрес пространства имён w, под которым идут все элементы в файле
            $content = $simple->children('http://schemas.openxmlformats.org/wordprocessingml/2006/main');
            $entries = [];

            if ($content->body->p) {
                foreach ($content->body->p as $paragraph) {
                    $inner_text = '';
                    $text_align = $paragraph->pPr->jc ? (string)$paragraph->pPr->jc->attributes('w', true)->{'val'} : null;
                    if ($text_align == 'center') $class = "class='ql-align-center'";
                    else if ($text_align == 'right') $class = "class='ql-align-right'";
                    else $class = null;

                    foreach ($paragraph->r as $run) {
                        if ($run->rPr->b && $run->rPr->i) $inner_text .= "<strong><em>$run->t</em></strong>";
                        else if ($run->rPr->b) $inner_text .= "<strong>$run->t</strong>";
                        else if ($run->rPr->i) $inner_text .= "<em>$run->t</em>";
                        else $inner_text .= $run->t;
                    }
                    $entries[] = "<p $class>$inner_text</p>";
                }
            }
            $this->deleteFolder('uploaded_files/' . $directory);
            return implode($entries);
        }
    }

    public function extractText($fileName) {
        if (!is_dir('uploaded_files/' . $fileName)) {
            $zip = new ZipArchive();
            if ($zip->open('uploaded_files/' . $fileName) === true) {
                $zip->extractTo('uploaded_files/' . pathinfo($fileName)['filename']);
                $zip->close();
            }
        }
        if (file_exists('uploaded_files/' . $fileName)) unlink('uploaded_files/' . $fileName);
        return pathinfo($fileName)['filename'];
    }


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
}