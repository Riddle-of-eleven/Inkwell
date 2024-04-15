<?php

namespace app\models;

use yii\base\Model;

class FormCreateCollection extends Model
{
    public $user_id;
    public $title;
    public $is_private;
    public $book_id;

    public function rules() {
        return [
            ['book_id', 'integer'],
            ['is_private', 'boolean'],
            ['title', 'required', 'message' => 'Вы должны ввести название подборки'],
        ];
    }
}