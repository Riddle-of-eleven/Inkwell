<?php

namespace app\widgets;

use yii\base\Widget;

class BookDisplay extends Widget
{
    public $data;
    public function run ()
    {
        return $this->render('bookDisplay', [
            'data' => $this->data,
        ]);
    }
}