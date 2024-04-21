<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fandom".
 *
 * @property int $id
 * @property int|null $this_creator_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $created_at
 *
 * @property BookFandom[] $bookFandoms
 * @property Character[] $characters
 * @property FavoriteFandom[] $favoriteFandoms
 * @property Origin[] $origins
 * @property RecycleBin[] $recycleBins
 * @property TagRequest[] $tagRequests
 * @property User $thisCreator
 */
class Fandom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fandom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['this_creator_id'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
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
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[BookFandoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookFandoms()
    {
        return $this->hasMany(BookFandom::class, ['fandom_id' => 'id']);
    }

    /**
     * Gets query for [[Characters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacters()
    {
        return $this->hasMany(Character::class, ['fandom_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteFandoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteFandoms()
    {
        return $this->hasMany(FavoriteFandom::class, ['fandom_id' => 'id']);
    }

    /**
     * Gets query for [[Origins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigins()
    {
        return $this->hasMany(Origin::class, ['fandom_id' => 'id']);
    }

    /**
     * Gets query for [[RecycleBins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecycleBins()
    {
        return $this->hasMany(RecycleBin::class, ['fandom_id' => 'id']);
    }

    /**
     * Gets query for [[TagRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagRequests()
    {
        return $this->hasMany(TagRequest::class, ['fandom_id' => 'id']);
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

    public static function getFandomsList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
