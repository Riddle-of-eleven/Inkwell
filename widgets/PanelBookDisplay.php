<?php

namespace app\widgets;

use yii\base\Widget;

class PanelBookDisplay extends Widget
{
    public $data;
    public function run()
    {
        return $this->render('panelBookDisplay', [
            'data' => $this->data,
        ]);
    }
}