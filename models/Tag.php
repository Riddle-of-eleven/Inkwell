<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $created_at
 * @property int|null $fandom_id
 * @property int|null $tag_type_id
 * @property int $is_only_for_fanfic
 * @property int $moderator_id
 *
 * @property BookTag[] $bookTags
 * @property TagType $tagType
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
            [['fandom_id', 'tag_type_id', 'is_only_for_fanfic'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['tag_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TagType::class, 'targetAttribute' => ['tag_type_id' => 'id']],
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
            'fandom_id' => 'Fandom ID',
            'tag_type_id' => 'Tag Type ID',
            'is_only_for_fanfic' => 'Is Only For Fanfic',
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
     * Gets query for [[TagType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagType()
    {
        return $this->hasOne(TagType::class, ['id' => 'tag_type_id']);
    }

    public static function getTagsList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
