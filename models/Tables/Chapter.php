<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "chapter".
 *
 * @property int $id
 * @property int|null $book_id
 * @property string|null $created_at
 * @property string|null $title
 * @property int|null $is_draft
 * @property int|null $is_section
 * @property int|null $parent_id
 * @property int|null $order
 * @property int|null $previous_id
 * @property string|null $content
 *
 * @property Book $book
 * @property Chapter[] $chapters
 * @property Chapter[] $chapters0
 * @property Comment[] $comments
 * @property Chapter $parent
 * @property Chapter $previous
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
            [['book_id', 'is_draft', 'is_section', 'parent_id', 'order', 'previous_id'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chapter::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['previous_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chapter::class, 'targetAttribute' => ['previous_id' => 'id']],
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
            'is_section' => 'Is Section',
            'parent_id' => 'Parent ID',
            'order' => 'Order',
            'previous_id' => 'Previous ID',
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
     * Gets query for [[Chapters0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChapters0()
    {
        return $this->hasMany(Chapter::class, ['previous_id' => 'id']);
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
     * Gets query for [[Previous]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrevious()
    {
        return $this->hasOne(Chapter::class, ['id' => 'previous_id']);
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
