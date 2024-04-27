<?php

namespace app\models\Tables;

/**
 * This is the model class for table "recycle_bin".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $book_id
 * @property int|null $fandom_id
 * @property string|null $deleted_at
 * @property int|null $days_stored
 *
 * @property Book $book
 * @property Fandom $fandom
 * @property User $user
 */
class RecycleBin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recycle_bin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'book_id', 'fandom_id', 'days_stored'], 'integer'],
            [['deleted_at'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['fandom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fandom::class, 'targetAttribute' => ['fandom_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'book_id' => 'Book ID',
            'fandom_id' => 'Fandom ID',
            'deleted_at' => 'Deleted At',
            'days_stored' => 'Days Stored',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
