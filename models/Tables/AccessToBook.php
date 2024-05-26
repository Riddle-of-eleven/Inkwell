<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "access_to_book".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $coauthor_id
 * @property int|null $beta_id
 * @property int|null $gamma_id
 *
 * @property User $beta
 * @property Book $book
 * @property User $coauthor
 * @property User $gamma
 */
class AccessToBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_to_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'coauthor_id', 'beta_id', 'gamma_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['coauthor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['coauthor_id' => 'id']],
            [['beta_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['beta_id' => 'id']],
            [['gamma_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['gamma_id' => 'id']],
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
            'coauthor_id' => 'Coauthor ID',
            'beta_id' => 'Beta ID',
            'gamma_id' => 'Gamma ID',
        ];
    }

    /**
     * Gets query for [[Beta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeta()
    {
        return $this->hasOne(User::class, ['id' => 'beta_id']);
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
     * Gets query for [[Coauthor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoauthor()
    {
        return $this->hasOne(User::class, ['id' => 'coauthor_id']);
    }

    /**
     * Gets query for [[Gamma]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGamma()
    {
        return $this->hasOne(User::class, ['id' => 'gamma_id']);
    }
}
