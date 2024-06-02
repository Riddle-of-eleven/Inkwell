<?php

namespace app\widgets;

use yii\base\Widget;

class PanelBookDisplay extends Widget
{
    public $book;
    public function run()
    {
        return $this->render('panel-book-display', [
            'book' => $this->book,
        ]);
    }
}