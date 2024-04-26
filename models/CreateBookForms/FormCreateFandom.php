<?php

namespace app\models\CreateBookForms;

use yii\base\Model;

class FormCreateFandom extends Model
{
    public $type;
    public $fandoms;
    /*public $origin;
    public $characters;*/

    public function rules() {
        return [
            ['type', 'required'],
            ['fandoms', 'trim'],
            //[['fandom', 'origin'], 'integer'],
            //[['characters'], 'trim'],
        ];
    }
}