<?php

namespace app\models\CreateBookForms;

use yii\base\Model;

class FormCreateMain extends Model
{
    public $title;
    public $relation;
    public $rating;
    public $plan_size;
    public $genres;

     public function rules() {
        return [
            [['relation', 'rating', 'plan_size', 'genres'], 'required'],
        ];
    }

}