<?php

namespace app\models\Forms;

use yii\base\Model;

class FormCreateCollection extends Model
{
    //public $user_id;
    public $book_id;
    public $title;
    public $is_private;

    public function rules() {
        return [
            ['book_id', 'integer'],
            ['is_private', 'boolean'],
            ['title', 'required', 'message' => 'Вы должны ввести название подборки'],
        ];
    }
}