<?php

namespace app\widgets;

use yii\base\Widget;

class AuthorDisplay extends Widget
{
    public $author;
    public function run() {
        return $this->render('author-display', [
            'author' => $this->author
        ]);
    }
}