<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property string|null $title
 * @property string $singular_title
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
            [['singular_title'], 'required'],
            [['title', 'singular_title'], 'string', 'max' => 500],
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
            'singular_title' => 'Singular Title',
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
