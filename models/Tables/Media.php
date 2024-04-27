<?php

namespace app\models\Tables;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property Origin[] $origins
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
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
     * Gets query for [[Origins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigins()
    {
        return $this->hasMany(Origin::class, ['media_id' => 'id']);
    }
}
