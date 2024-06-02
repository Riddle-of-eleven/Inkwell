<?php

namespace app\widgets;

use yii\base\Widget;

class BookDisplay extends Widget
{
    public $book;
    public function run () {
        return $this->render('book-display', [
            'book' => $this->book,
        ]);
    }
}