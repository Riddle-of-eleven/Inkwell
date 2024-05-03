<?php

namespace app\models\Tables;

/**
 * This is the model class for table "user_achievements".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $achievement_id
 *
 * @property Achievements $achievement
 * @property User $user
 */
class UserAchievements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_achievements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'achievement_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['achievement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Achievements::class, 'targetAttribute' => ['achievement_id' => 'id']],
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
            'achievement_id' => 'Achievement ID',
        ];
    }

    /**
     * Gets query for [[Achievement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievement()
    {
        return $this->hasOne(Achievements::class, ['id' => 'achievement_id']);
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
