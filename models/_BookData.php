<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\i18n\Formatter;

class _BookData extends ActiveRecord
{
    public int $id;
    public string $created_at;
    public bool $is_draft;
    public bool $is_perfect; // ?????
    public int $is_editable;
    public string $title;
    public string $cover;
    public string $description;
    public string $remark;
    public string $dedication;
    public string $disclaimer;
    public bool $is_published;
    public bool $type;

    public array $fandoms;
    public array $origins;


    public User $author;


    /**
     * @throws InvalidConfigException
     */
    public function __construct($id)
    {
        $formatter = new Formatter();
        $book = Book::findOne($id);

        $this->id = $id;
//        $this->created_at = $formatter->asDatetime($book->created_at);
        $this->created_at = $book->created_at;
        $this->is_draft = $book->is_draft;
        $this->is_perfect = $book->is_perfect;
        $this->is_editable = $book->is_editable;
        $this->title = $book->title;
        $this->cover = is_null($book->cover) ? '' : $book->cover;
        $this->description = $book->description;
        $this->remark = $book->remark;
        $this->dedication = $book->dedication;
        $this->disclaimer = $book->disclaimer;
        $this->is_published = $book->is_published;

        $this->type = !($book->type == 1); // true, если фанфик
//        if ($this->type) {
//            // здесь надо описать запись в массив данных о фэндомах и первоисточниках
//            $this->fandoms['id'] = $book->
//        }

        $this->author = User::findOne($book->user_id);



        parent::__construct();
    }
}