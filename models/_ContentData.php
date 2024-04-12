<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

class _ContentData extends ActiveRecord
{
    public $book_id;
    public $root;
    public $offspring;


    public function __construct($book_id)
    {
        $this->book_id = $book_id;
        $this->root = Chapter::find()->where(['book_id' => $book_id, 'parent_id' => null])->orderBy('order')->all();

        foreach ($this->root as $r) {
            $this->offspring[$r->id] = Chapter::find()->where(['parent_id' => $r->id])->orderBy('order')->all();
        }

        parent::__construct();
    }
}