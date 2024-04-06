<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complaint".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $text
 * @property int|null $is_resolved
 * @property int|null $resolving_moderator_id
 *
 * @property User $resolvingModerator
 * @property User $user
 */
class Complaint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complaint';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'is_resolved', 'resolving_moderator_id'], 'integer'],
            [['text'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['resolving_moderator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['resolving_moderator_id' => 'id']],
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
            'text' => 'Text',
            'is_resolved' => 'Is Resolved',
            'resolving_moderator_id' => 'Resolving Moderator ID',
        ];
    }

    /**
     * Gets query for [[ResolvingModerator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResolvingModerator()
    {
        return $this->hasOne(User::class, ['id' => 'resolving_moderator_id']);
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
