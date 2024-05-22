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
            [['old_password', 'new_password'],
                'string',
                'length' => [8, 40],
                'message' => 'Некорректная длина',
                'tooShort' => 'Пароль должен содержать минимум 8 символов'],
            ['email', 'email', 'message' => 'Некорректный email'],
            ['email', 'required', 'message' => 'Данное поле не может быть пустым'],

            ['new_password', 'comparePasswords']
        ];
    }

    public function attributeLabels() {
        return [
            'login' => 'Имя пользователя',
            'old_password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
            'email' => 'Электронная почта',
        ];
    }


    public function comparePasswords($attribute) {
        if ($this->old_password === $this->$attribute)
            $this->addError($attribute, 'Новый и старый пароли не должны совпадать');
    }
}