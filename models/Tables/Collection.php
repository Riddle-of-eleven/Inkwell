<?php

namespace app\models\Tables;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $is_private
 * @property string $created_at
 *
 * @property User $user
 *
 * @property Book[] $books
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at'], 'required'],
            [['user_id', 'is_private'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 2500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'description' => 'Description',
            'is_private' => 'Is Private',
            'created_at' => 'Created At',
        ];
    }


    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
                        ->viaTable('book_collection', ['collection_id' => 'id']);
    }

    public function getBookCount()
    {
        return count($this->books);
    }
}
