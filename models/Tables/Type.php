<?php

namespace app\models\Tables;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "type".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 *
 * @property Book[] $books
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
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
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['type_id' => 'id']);
    }

    public static function getTypesList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
