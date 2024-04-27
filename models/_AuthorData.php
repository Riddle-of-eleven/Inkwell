<?php

namespace app\models;

use app\models\Tables\User;
use yii\db\ActiveRecord;

class _AuthorData extends ActiveRecord
{
    public int $id;
    public function __construct($id)
    {
        $author = User::findOne($id);
        $this->id = $id;

        parent::__construct();
    }
}