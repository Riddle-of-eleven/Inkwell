<?php

namespace app\models;

use yii\base\Model;

class FormCreateCollection extends Model
{
    public $user_id;
    public $collection;
    public $is_private;

    public function rules() {
        return [
            //['user_id', 'integer'],
            ['s_private', 'boolean'],
            ['collection', 'required', 'message' => 'Вы должны ввести название подборки'],
        ];
    }
}