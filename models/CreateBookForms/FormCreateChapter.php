<?php

namespace app\models\CreateBookForms;

use yii\base\Model;

class FormCreateChapter extends Model
{
    public $title;
    public $is_draft;
    //public $is_section;
    public $content;
    public $file;

    public function rules() {
        return [
            [['title', 'content'], 'required'],
            ['file', 'safe']
        ];
    }
}