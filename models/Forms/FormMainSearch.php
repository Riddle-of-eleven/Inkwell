<?php

namespace app\models\Forms;

use yii\base\Model;

class FormMainSearch extends Model
{
    public $query;
    public function rules() {
        return [
            ['query', 'required'],
            ['query', 'string', 'max' => 200]
        ];
    }

}