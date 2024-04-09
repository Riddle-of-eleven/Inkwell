<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int $genre_type_id
 *
 * @property BookGenre[] $bookGenres
 * @property GenreType $genreType
 */
class Genre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['genre_type_id'], 'required'],
            [['genre_type_id'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['genre_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GenreType::class, 'targetAttribute' => ['genre_type_id' => 'id']],
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
            'genre_type_id' => 'Genre Type ID',
        ];
    }

    /**
     * Gets query for [[BookGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookGenres()
    {
        return $this->hasMany(BookGenre::class, ['genre_id' => 'id']);
    }

    /**
     * Gets query for [[GenreType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenreType()
    {
        return $this->hasOne(GenreType::class, ['id' => 'genre_type_id']);
    }
}
