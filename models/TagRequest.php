<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_request".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $fandom_id
 * @property string|null $created_at
 * @property string|null $title
 * @property string|null $description
 * @property string|null $relevance
 * @property int|null $is_approved
 * @property int|null $approving_moderator_id
 *
 * @property User $approvingModerator
 * @property Fandom $fandom
 * @property User $user
 */
class TagRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'fandom_id', 'is_approved', 'approving_moderator_id'], 'integer'],
            [['created_at'], 'safe'],
            [['relevance'], 'string'],
            [['title', 'description'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['fandom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fandom::class, 'targetAttribute' => ['fandom_id' => 'id']],
            [['approving_moderator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['approving_moderator_id' => 'id']],
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
            'created_at' => 'Created At',
            'title' => 'Title',
            'description' => 'Description',
            'relevance' => 'Relevance',
            'is_approved' => 'Is Approved',
            'approving_moderator_id' => 'Approving Moderator ID',
        ];
    }

    /**
     * Gets query for [[ApprovingModerator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApprovingModerator()
    {
        return $this->hasOne(User::class, ['id' => 'approving_moderator_id']);
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
