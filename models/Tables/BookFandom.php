<?php

namespace app\models\Tables;

/**
 * This is the model class for table "book_fandom".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $fandom_id
 *
 * @property Book $book
 * @property Fandom $fandom
 */
class BookFandom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_fandom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'fandom_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['fandom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fandom::class, 'targetAttribute' => ['fandom_id' => 'id']],
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
            'fandom_id' => 'Fandom ID',
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
     * Gets query for [[Fandom]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFandom()
    {
        return $this->hasOne(Fandom::class, ['id' => 'fandom_id']);
    }
}
