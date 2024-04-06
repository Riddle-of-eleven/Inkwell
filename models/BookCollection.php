<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_collection".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $collection_id
 * @property int|null $collection_section_id
 *
 * @property Book $book
 * @property Collection $collection
 * @property CollectionSection $collectionSection
 */
class BookCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'collection_id', 'collection_section_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::class, 'targetAttribute' => ['collection_id' => 'id']],
            [['collection_section_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollectionSection::class, 'targetAttribute' => ['collection_section_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'collection_id' => 'Collection ID',
            'collection_section_id' => 'Collection Section ID',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[Collection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::class, ['id' => 'collection_id']);
    }

    /**
     * Gets query for [[CollectionSection]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollectionSection()
    {
        return $this->hasOne(CollectionSection::class, ['id' => 'collection_section_id']);
    }
}
