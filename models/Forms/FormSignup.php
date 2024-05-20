<?php

namespace app\models\Forms;

use yii\base\Model;

class FormSignup extends Model
{
    public $email;
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['email', 'login', 'password'], 'required', 'message'=> 'Это поле обязательно'],
            ['login', 'string', 'length' => [6, 50], 'message' => 'Некорректная длина'],
            ['password', 'string', 'length' => [8, 40], 'message' => 'Некорректная длина'],
            ['email', 'email', 'message' => 'Некорректный email'],
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Имя пользователя',
            'password' => 'Пароль',
            'email' => 'Электронная почта',
        ];
    }
}