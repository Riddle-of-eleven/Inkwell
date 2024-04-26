<?php

namespace app\models\Forms\Moderator;


class FormCreateTag extends \yii\base\Model
{
    public $title;
    public $description;
    public $type;
    //public $created_at;
    //public $fandom;
    //public $is_only_for_fanfic;
    //public $moderator; // а надо ли вообще это свойство?

    public function rules()
    {
        return [
            [['title', 'description', 'type'], 'required'],
        ];
    }
}