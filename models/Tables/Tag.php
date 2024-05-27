<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $created_at
 * @property int|null $fandom_id
 * @property int|null $type_id
 * @property int|null $is_only_for_fanfic
 * @property int|null $moderator_id
 *
 * @property BookTag[] $bookTags
 * @property Fandom $fandom
 * @property User $moderator
 * @property TagType $type
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['fandom_id', 'type_id', 'is_only_for_fanfic', 'moderator_id'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TagType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['moderator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['moderator_id' => 'id']],
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
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'fandom_id' => 'Fandom ID',
            'type_id' => 'Type ID',
            'is_only_for_fanfic' => 'Is Only For Fanfic',
            'moderator_id' => 'Moderator ID',
        ];
    }

    /**
     * Gets query for [[BookTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookTags()
    {
        return $this->hasMany(BookTag::class, ['tag_id' => 'id']);
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
     * Gets query for [[Moderator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModerator()
    {
        return $this->hasOne(User::class, ['id' => 'moderator_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TagType::class, ['id' => 'type_id']);
    }
}
