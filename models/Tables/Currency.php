<?php

namespace app\models\Tables;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $code
 *
 * @property AccessLevel[] $accessLevels
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 500],
            [['code'], 'string', 'max' => 20],
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
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[AccessLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessLevels()
    {
        return $this->hasMany(AccessLevel::class, ['currency_id' => 'id']);
    }
}
