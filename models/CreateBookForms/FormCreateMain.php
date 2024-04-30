<?php

namespace app\models\CreateBookForms;

use yii\base\Model;

class FormCreateMain extends Model
{
    public $title;
    public $description;
    public $remark;
    public $disclaimer;
    public $dedication;


    public $relation;
    public $rating;
    public $plan_size;
    public $genres;
    public $tags;

     public function rules() {
        return [
            [['title', 'description', 'relation', 'rating', 'plan_size', 'genres', 'tags'], 'required', 'message' => 'Это поле обязательно'],
            [['remark', 'disclaimer', 'dedication'], 'string'],

            // чё с этим делать и как?
            //[['genres', 'tags'], 'required'],
        ];
    }

}