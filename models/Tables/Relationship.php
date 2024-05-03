<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "relationship".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string $symbol
 * @property string $html_symbol
 */
class Relationship extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relationship';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['symbol', 'html_symbol'], 'required'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['symbol', 'html_symbol'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'symbol' => 'Symbol',
            'html_symbol' => 'Html Symbol',
        ];
    }
}
