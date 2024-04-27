<?php

namespace app\models\Tables;

/**
 * This is the model class for table "collection_section".
 *
 * @property int $id
 * @property int|null $collection_id
 * @property string|null $title
 * @property string|null $description
 *
 * @property BookCollection[] $bookCollections
 */
class CollectionSection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collection_id'], 'integer'],
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
            'collection_id' => 'Collection ID',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[BookCollections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookCollections()
    {
        return $this->hasMany(BookCollection::class, ['collection_section_id' => 'id']);
    }
}
