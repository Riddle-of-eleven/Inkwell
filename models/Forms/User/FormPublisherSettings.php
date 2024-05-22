<?php

namespace app\models\Forms\User;

use yii\base\Model;

class FormPublisherSettings extends Model
{
    public $official_website;
    public function rules() {
        return [
            ['official_website', 'trim']
        ];
    }

    public function attributeLabels()
    {
        return ['official_website' => 'Адрес официального сайта'];
    }
}