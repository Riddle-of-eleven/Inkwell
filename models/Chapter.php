<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chapter".
 *
 * @property int $id
 * @property int|null $book_id
 * @property string|null $created_at
 * @property string|null $title
 * @property int|null $is_draft
 * @property int|null $parent_id
 * @property int|null $order
 * @property string|null $content
 *
 * @property Book $book
 * @property Chapter[] $chapters
 * @property Comment[] $comments
 * @property Chapter $parent
 * @property Read[] $reads
 * @property ViewHistory[] $viewHistories
 */
class Chapter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chapter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'is_draft', 'parent_id', 'order'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chapter::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'created_at' => 'Created At',
            'title' => 'Title',
            'is_draft' => 'Is Draft',
            'parent_id' => 'Parent ID',
            'order' => 'Order',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    /**
     * Gets query for [[Chapters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChapters()
    {
        return $this->hasMany(Chapter::class, ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['chapter_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Chapter::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Reads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReads()
    {
        return $this->hasMany(Read::class, ['chapter_id' => 'id']);
    }

    /**
     * Gets query for [[ViewHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewHistories()
    {
        return $this->hasMany(ViewHistory::class, ['chapter_id' => 'id']);
    }
}
