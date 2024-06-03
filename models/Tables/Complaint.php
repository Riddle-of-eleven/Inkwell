<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "complaint".
 *
 * @property int $id
 * @property int|null $book_id
 * @property int|null $user_id
 * @property string|null $text
 * @property int|null $is_resolved
 * @property int|null $resolving_moderator_id
 * @property int|null $reason_id
 *
 * @property Book $book
 * @property ComplaintReason $reason
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
            [['book_id', 'user_id', 'is_resolved', 'resolving_moderator_id', 'reason_id'], 'integer'],
            [['text'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['resolving_moderator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['resolving_moderator_id' => 'id']],
            [['reason_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComplaintReason::class, 'targetAttribute' => ['reason_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
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
            'text' => 'Text',
            'is_resolved' => 'Is Resolved',
            'resolving_moderator_id' => 'Resolving Moderator ID',
            'reason_id' => 'Reason ID',
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
     * Gets query for [[Reason]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReason()
    {
        return $this->hasOne(ComplaintReason::class, ['id' => 'reason_id']);
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
