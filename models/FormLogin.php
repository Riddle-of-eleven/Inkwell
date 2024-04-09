<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;

class FormLogin extends Model
{
    public $login;
    public $password;
    public $remember_me = true;
    public $aaa;

    public $_user;

    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Это поле обязательно'],
            ['login', 'string', 'length' => [6, 50], 'message' => 'Некорректная длина'],
            ['remember_me', 'boolean'],
            ['password', 'string', 'length' => [8, 40], 'message' => 'Некорректная длина'],
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600*24*30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = User::findByUsername($this->login);
        }

        return $this->_user;
    }
}