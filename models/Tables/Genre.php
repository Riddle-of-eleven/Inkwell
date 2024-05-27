<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "genre".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $created_at
 * @property int $type_id
 * @property int|null $moderator_id
 *
 * @property BookGenre[] $bookGenres
 * @property User $moderator
 * @property GenreType $type
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
            [['created_at'], 'safe'],
            [['type_id'], 'required'],
            [['type_id', 'moderator_id'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => GenreType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['moderator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['moderator_id' => 'id']],
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
            'type_id' => 'Type ID',
            'moderator_id' => 'Moderator ID',
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
        return $this->hasOne(GenreType::class, ['id' => 'type_id']);
    }
}
