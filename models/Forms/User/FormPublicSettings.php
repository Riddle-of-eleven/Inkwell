<?php

namespace app\models\Forms\User;

use yii\base\Model;

class FormPublicSettings extends Model
{
    public $about;
    public $contact;

    public function rules() {
        return [
            ['about', 'string', 'length' => [6, 800], 'message' => 'Некорректная длина'],
            ['contact', 'string', 'length' => [6, 500], 'message' => 'Некорректная длина'],
        ];
    }
}