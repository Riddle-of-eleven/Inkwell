<?php

namespace app\models\CreateBookForms;

use yii\base\Model;

class FormCreateCover extends Model
{
    public $cover;

    public function rules()
    {
        return [
            // сайт yii говорит, что есть валидатор image, попробуй его потом
            [['cover'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            $path = 'images/covers/uploads/' . $this->cover->baseName . '.' . $this->cover->extension;
            $this->cover->saveAs($path);
            return $path;
        }
        else return false;
    }
}