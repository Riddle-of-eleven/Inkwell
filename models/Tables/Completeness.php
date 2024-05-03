<?php

namespace app\models\Tables;

/**
 * This is the model class for table "completeness".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 *
 * @property Book[] $books
 */
class Completeness extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'completeness';
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
        return $this->hasMany(Book::class, ['completeness_id' => 'id']);
    }
}
