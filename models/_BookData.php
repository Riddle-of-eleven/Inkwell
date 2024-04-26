<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
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
    public array $characters;


    public User $author;

    public Rating $rating;
    public Relation $relation;
    public Completeness $completeness;

    public array $genres;
    public array $tags;


    public function __construct($id)
    {
        $formatter = new Formatter();
        $book = Book::findOne($id);
        //VarDumper::dump($book, 10, true); die;
        //if ($book->is_draft == 0 && $book->is_process == 0) {

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
            $this->dedication = is_null($book->dedication) ? '' : $book->dedication;
            $this->disclaimer = is_null($book->disclaimer) ? '' : $book->disclaimer;
            $this->is_published = is_null($book->is_published) ? '' : $book->is_published;

            $this->type = !($book->type->id == 1); // true, если фанфик

            if ($this->type) {
                $this->fandoms = $book->fandoms;
                $this->origins = $book->origins;
            }
            $this->author = User::findOne($book->user_id);

            $this->characters = $book->characters;

            /*VarDumper::dump($book->characters, 10, true);
            die;*/

            $this->rating = $book->rating;
            $this->relation = $book->relation0;
            $this->completeness = $book->completeness;

            $this->genres = $book->genres;
            $this->tags = $book->tags;
        //}


        parent::__construct();
    }
}