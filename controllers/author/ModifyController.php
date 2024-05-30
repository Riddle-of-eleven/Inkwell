<?php

namespace app\controllers\author;

use app\models\_ContentData;
use app\models\Tables\Book;
use app\models\Tables\Chapter;
use SimpleXMLElement;
use yii\helpers\Url;
use Yii;
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

        return $this->renderAjax('tabs/main', [
            'book' => $book,
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



    public function actionAddChapter() {
        $session = Yii::$app->session;
        $book = $session->has('modify.book') ? $session->get('modify.book') : null;
        if (!$book) return $this->goHome();
        $this_book = Book::findOne($book);
        return $this->render('add-chapter', [
            'book' => $this_book,
        ]);
    }

    public function actionProcessFile() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $fileName = uniqid() . '.' . $file->extension;
            $path = 'uploaded_files/' . $fileName;
            if ($file->saveAs($path)) {
                $content = false;
                if ($file->extension == 'odt') $content = $this->proceedODT($fileName);
                //else if ($file->extension == 'docx') $content = $this->proceedDOCX($fileName);
                return $content;
            }
        }
        return false;
    }




    public function proceedODT($fileName) {
        $directory = $this->extractText($fileName);
        // получение содержимого
        if (file_exists('uploaded_files/' . $directory . '/content.xml')) {
            $xml = file_get_contents('uploaded_files/' . $directory . '/content.xml');
            $simple = new SimpleXMLElement($xml);

            // пространства имён
            $ns_office = 'urn:oasis:names:tc:opendocument:xmlns:office:1.0';
            $ns_styles = 'urn:oasis:names:tc:opendocument:xmlns:style:1.0';
            $ns_text = 'urn:oasis:names:tc:opendocument:xmlns:text:1.0';

            $simple->registerXPathNamespace("office", $ns_office);
            $simple->registerXPathNamespace("style", $ns_styles);

            $styles = [];
            $names = $simple->xpath('//office:automatic-styles/style:style/@style:name');

            foreach ($names as $name) {
                $title = (string) $name;
                $text_attributes = $simple->xpath("//office:automatic-styles/style:style[@style:name='$title']/style:text-properties");
                $paragraph_attributes = $simple->xpath("//office:automatic-styles/style:style[@style:name='$title']/style:paragraph-properties");

                $font_weight = $text_attributes ? (string) $text_attributes[0]->attributes('fo', true)->{'font-weight'} : null;
                $font_style =  $text_attributes ? (string) $text_attributes[0]->attributes('fo', true)->{'font-style'} : null;
                $text_align = $paragraph_attributes ? (string) $paragraph_attributes[0]->attributes('fo', true)->{'text-align'} : null;
                if ($text_align == 'justify') $text_align = null;

                if (!$font_style && !$font_weight)
                    $styles['p'][$title] = [
                        'text-align' => $text_align
                    ];
                else $styles['t'][$title] = [
                    'font-weight' => $font_weight,
                    'font-style' => $font_style,
                ];
            }

            $entries = [];
            $texts = $simple->xpath("//office:body/office:text//text:p");
            foreach ($texts as $text) {
                $entry = $text->asXML();
                $entry_style = $text->attributes('text', true)->{'style-name'};
                preg_match_all('/<text:p.*?>(.*?)<\/text:p>/s', $entry, $matches);
                $inner_text = $matches[1][0] ?? '';

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

                if ($styles['p'][(string)$entry_style]['text-align'] == 'center') $class = 'ql-align-center';
                else if ($styles['p'][(string)$entry_style]['text-align'] == 'end') $class = 'ql-align-right';
                else $class = null;

                if ($class) $entries[] = "<p class='$class'>$inner_text</p>";
                else $entries[] = "<p>$inner_text</p>";
            }

            $this->deleteFolder('uploaded_files/' . $directory);
            return $entries;
        }
    }
    public function proceedDOCX($fileName) {
        $dirName = $this->extractText($fileName);
        return $dirName;
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