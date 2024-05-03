<?php

namespace app\models\Tables;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag_type".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property Tag[] $tags
 */
class TagType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 500],
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
        ];
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['tag_type_id' => 'id']);
    }

    public static function getTagTypesList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
