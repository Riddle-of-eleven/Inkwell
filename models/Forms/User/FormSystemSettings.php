<?php

namespace app\models\Forms\User;

use yii\base\Model;

class FormSystemSettings extends Model
{
    public $login;
    public $old_password;
    public $new_password;
    public $email;

    public function rules() {
        return [
            ['login', 'string', 'length' => [6, 50], 'message' => 'Некорректная длина'],
            [['old_password', 'new_password'], 'string', 'length' => [8, 40], 'message' => 'Некорректная длина'],
            ['email', 'email', 'message' => 'Некорректный email'],
        ];
    }
}