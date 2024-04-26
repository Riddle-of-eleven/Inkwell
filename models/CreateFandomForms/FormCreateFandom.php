<?php

namespace app\models\CreateFandomForms;

use yii\base\Model;

class FormCreateFandom extends Model
{
    public $title;
    public $description;

    public function rules()
    {
        return [
            ['title', 'required' ],
            ['description', 'required' ],
        ];
    }
}