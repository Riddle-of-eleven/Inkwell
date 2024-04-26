<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "followers".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $follower_id
 * @property string|null $followed_at
 *
 * @property User $follower
 * @property User $user
 */
class Followers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'followers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'follower_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['follower_id' => 'id']],
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
            'follower_id' => 'Follower ID',
        ];
    }

    /**
     * Gets query for [[Follower]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne(User::class, ['id' => 'follower_id']);
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
