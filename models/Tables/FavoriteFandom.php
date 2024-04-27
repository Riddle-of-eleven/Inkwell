<?php

namespace app\models\Tables;

/**
 * This is the model class for table "favorite_fandom".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $fandom_id
 *
 * @property Fandom $fandom
 * @property User $user
 */
class FavoriteFandom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite_fandom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fandom_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'fandom_id' => 'Fandom ID',
        ];
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
