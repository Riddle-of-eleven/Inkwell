<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $is_private
 *
 * @property BookCollection[] $bookCollections
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_private'], 'integer'],
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
            'is_private' => 'Is Private',
        ];
    }

    /**
     * Gets query for [[BookCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookCollections()
    {
        return $this->hasMany(BookCollection::class, ['collection_id' => 'id']);
    }
}
