<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "book_origin".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $origin_id
 *
 * @property Book $book
 * @property Origin $origin
 */
class BookOrigin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_origin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'origin_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['origin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Origin::class, 'targetAttribute' => ['origin_id' => 'id']],
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
            'origin_id' => 'Origin ID',
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
     * Gets query for [[Origin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigin()
    {
        return $this->hasOne(Origin::class, ['id' => 'origin_id']);
    }
}
