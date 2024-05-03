<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "pairing".
 *
 * @property int $id
 * @property int $characterA_id
 * @property int $characterB_id
 * @property int $book_id
 *
 * @property Book $book
 * @property Character $characterA
 * @property Character $characterB
 */
class Pairing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pairing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['characterA_id', 'characterB_id', 'book_id'], 'required'],
            [['characterA_id', 'characterB_id', 'book_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['characterA_id'], 'exist', 'skipOnError' => true, 'targetClass' => Character::class, 'targetAttribute' => ['characterA_id' => 'id']],
            [['characterB_id'], 'exist', 'skipOnError' => true, 'targetClass' => Character::class, 'targetAttribute' => ['characterB_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characterA_id' => 'Character A ID',
            'characterB_id' => 'Character B ID',
            'book_id' => 'Book ID',
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
     * Gets query for [[CharacterA]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterA()
    {
        return $this->hasOne(Character::class, ['id' => 'characterA_id']);
    }

    /**
     * Gets query for [[CharacterB]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterB()
    {
        return $this->hasOne(Character::class, ['id' => 'characterB_id']);
    }
}
