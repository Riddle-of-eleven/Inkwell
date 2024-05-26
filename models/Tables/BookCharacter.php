<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "book_character".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $character_id
 *
 * @property Book $book
 * @property Character $character
 */
class BookCharacter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_character';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'character_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['character_id'], 'exist', 'skipOnError' => true, 'targetClass' => Character::class, 'targetAttribute' => ['character_id' => 'id']],
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
            'character_id' => 'Character ID',
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
     * Gets query for [[Character]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacter()
    {
        return $this->hasOne(Character::class, ['id' => 'character_id']);
    }
}
