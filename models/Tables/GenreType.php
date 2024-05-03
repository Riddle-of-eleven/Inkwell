<?php

namespace app\models\Tables;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "genre_type".
 *
 * @property int $id
 * @property string $title
 */
class GenreType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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

    public static function getGenreTypesList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
