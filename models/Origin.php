<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "origin".
 *
 * @property int $id
 * @property int|null $this_creator_id
 * @property int|null $fandom_id
 * @property string|null $title
 * @property int|null $media_id
 * @property string|null $description
 * @property string|null $creator
 * @property string|null $release_date
 *
 * @property BookOrigin[] $bookOrigins
 * @property CharacterOrigin[] $characterOrigins
 * @property Fandom $fandom
 * @property Media $media
 * @property User $thisCreator
 */
class Origin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'origin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['this_creator_id', 'fandom_id', 'media_id'], 'integer'],
            [['release_date'], 'safe'],
            [['title', 'creator'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['fandom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fandom::class, 'targetAttribute' => ['fandom_id' => 'id']],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::class, 'targetAttribute' => ['media_id' => 'id']],
            [['this_creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['this_creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'this_creator_id' => 'This Creator ID',
            'fandom_id' => 'Fandom ID',
            'title' => 'Title',
            'media_id' => 'Media ID',
            'description' => 'Description',
            'creator' => 'Creator',
            'release_date' => 'Release Date',
        ];
    }

    /**
     * Gets query for [[BookOrigins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookOrigins()
    {
        return $this->hasMany(BookOrigin::class, ['origin_id' => 'id']);
    }

    /**
     * Gets query for [[CharacterOrigins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterOrigins()
    {
        return $this->hasMany(CharacterOrigin::class, ['origin_id' => 'id']);
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
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::class, ['id' => 'media_id']);
    }

    /**
     * Gets query for [[ThisCreator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThisCreator()
    {
        return $this->hasOne(User::class, ['id' => 'this_creator_id']);
    }
}
