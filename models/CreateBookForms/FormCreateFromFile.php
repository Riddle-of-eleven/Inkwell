<?php

namespace app\models\CreateBookForms;

use yii\base\Model;
use yii\helpers\VarDumper;

class FormCreateFromFile extends Model
{
    public $title;
    public $file;

    public function rules()
    {
        return [
            ['title', 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'docx, odt'],
        ];
    }

    /*public function upload()
    {
        if ($this->validate()) {
            $path = 'chapter-files/'. $this->file->baseName . '.' . $this->file->extension;

            $this->file->saveAs($path);
            return $path;
        }
        else return false;
    }*/
}