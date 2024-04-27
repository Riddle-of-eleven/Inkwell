<?php

namespace app\models\Tables;

/**
 * This is the model class for table "access_to_book".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $user_id
 * @property int|null $co_author_1_id
 * @property int|null $co_author_2_id
 * @property int|null $beta_1_id
 * @property int|null $beta_2_id
 * @property int|null $gamma_1_id
 * @property int|null $gamma_2_id
 *
 * @property User $beta1
 * @property User $beta2
 * @property Book $book
 * @property User $coAuthor1
 * @property User $coAuthor2
 * @property User $gamma1
 * @property User $gamma2
 * @property User $user
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
            [['book_id', 'user_id', 'co_author_1_id', 'co_author_2_id', 'beta_1_id', 'beta_2_id', 'gamma_1_id', 'gamma_2_id'], 'integer'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['co_author_1_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['co_author_1_id' => 'id']],
            [['co_author_2_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['co_author_2_id' => 'id']],
            [['beta_1_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['beta_1_id' => 'id']],
            [['beta_2_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['beta_2_id' => 'id']],
            [['gamma_1_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['gamma_1_id' => 'id']],
            [['gamma_2_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['gamma_2_id' => 'id']],
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
            'user_id' => 'User ID',
            'co_author_1_id' => 'Co Author 1 ID',
            'co_author_2_id' => 'Co Author 2 ID',
            'beta_1_id' => 'Beta 1 ID',
            'beta_2_id' => 'Beta 2 ID',
            'gamma_1_id' => 'Gamma 1 ID',
            'gamma_2_id' => 'Gamma 2 ID',
        ];
    }

    /**
     * Gets query for [[Beta1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeta1()
    {
        return $this->hasOne(User::class, ['id' => 'beta_1_id']);
    }

    /**
     * Gets query for [[Beta2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBeta2()
    {
        return $this->hasOne(User::class, ['id' => 'beta_2_id']);
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
     * Gets query for [[CoAuthor1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoAuthor1()
    {
        return $this->hasOne(User::class, ['id' => 'co_author_1_id']);
    }

    /**
     * Gets query for [[CoAuthor2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoAuthor2()
    {
        return $this->hasOne(User::class, ['id' => 'co_author_2_id']);
    }

    /**
     * Gets query for [[Gamma1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGamma1()
    {
        return $this->hasOne(User::class, ['id' => 'gamma_1_id']);
    }

    /**
     * Gets query for [[Gamma2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGamma2()
    {
        return $this->hasOne(User::class, ['id' => 'gamma_2_id']);
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
