<?php

namespace app\models\Tables;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "relation".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 *
 * @property Book[] $books
 */
class Relation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'relation';
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
        return $this->hasMany(Book::class, ['relation_id' => 'id']);
    }

    public static function getRelationsList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
