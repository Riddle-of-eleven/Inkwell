<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "visits".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $visitor_id
 * @property string|null $visited_at
 * @property string|null $visitor_ip
 *
 * @property User $user
 * @property User $visitor
 */
class Visits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'visitor_id'], 'integer'],
            [['visited_at'], 'safe'],
            [['visitor_ip'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['visitor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['visitor_id' => 'id']],
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
            'visitor_id' => 'Visitor ID',
            'visited_at' => 'Visited At',
            'visitor_ip' => 'Visitor Ip',
        ];
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

    /**
     * Gets query for [[Visitor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisitor()
    {
        return $this->hasOne(User::class, ['id' => 'visitor_id']);
    }
}
