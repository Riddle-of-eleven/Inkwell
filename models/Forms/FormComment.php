<?php

namespace app\models\Forms;

use yii\base\Model;

class FormComment extends Model {
    public $comment;
    public $comment_type;

    public function rules() {
        return [
            ['comment_type', 'required'],
            ['comment', 'string', 'max' => 2000]
        ];
    }
}