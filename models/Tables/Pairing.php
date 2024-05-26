<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "pairing".
 *
 * @property int $id
 * @property int $book_id
 * @property int $relationship_id
 *
 * @property Book $book
 * @property PairingCharacter[] $pairingCharacters
 * @property Relationship $relationship
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
            [['book_id', 'relationship_id'], 'required'],
            [['book_id', 'relationship_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['relationship_id'], 'exist', 'skipOnError' => true, 'targetClass' => Relationship::class, 'targetAttribute' => ['relationship_id' => 'id']],
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
            'relationship_id' => 'Relationship ID',
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
     * Gets query for [[PairingCharacters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPairingCharacters()
    {
        return $this->hasMany(PairingCharacter::class, ['pairing_id' => 'id']);
    }

    /**
     * Gets query for [[Relationship]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelationship()
    {
        return $this->hasOne(Relationship::class, ['id' => 'relationship_id']);
    }
}
