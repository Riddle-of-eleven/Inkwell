<?php

namespace app\models\Forms\Moderator;

use yii\base\Model;

class FormChooseType extends Model
{
    public $type;

    public function rules()
    {
        return [['type', 'required']];
    }
}