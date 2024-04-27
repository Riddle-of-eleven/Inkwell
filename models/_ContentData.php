<?php

namespace app\models;

use app\models\Tables\Chapter;
use yii\db\ActiveRecord;

class _ContentData extends ActiveRecord
{
    public $book_id;
    public $root;
    public $offspring;
    public $chapters_count;


    public function __construct($book_id)
    {
        $this->book_id = $book_id;
        $this->root = Chapter::find()->where(['book_id' => $book_id, 'parent_id' => null])->orderBy('order')->all();

        foreach ($this->root as $r) {
            $this->offspring[$r->id] = Chapter::find()->where(['book_id' => $book_id, 'parent_id' => $r->id])->orderBy('order')->all();
        }

        $this->chapters_count = Chapter::find()->where(['book_id' => $book_id])->andWhere(['<>', 'is_section', true])->count();

        parent::__construct();
    }
}