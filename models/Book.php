<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $created_at
 * @property int|null $is_draft
 * @property int|null $is_perfect
 * @property int|null $is_editable
 * @property string|null $title
 * @property string|null $cover
 * @property string|null $description
 * @property string|null $remark
 * @property string|null $dedication
 * @property string|null $disclaimer
 * @property int|null $type_id
 * @property int|null $rating_id
 * @property int|null $completeness_id
 * @property int|null $relation_id
 * @property int|null $plan_size_id
 * @property int|null $real_size_id
 * @property int|null $publisher_id
 * @property int|null $is_published
 * @property int|null $access_level_id
 *
 * @property AccessLevel $accessLevel
 * @property AccessToBook[] $accessToBooks
 * @property Chapter[] $chapters
 * @property Comment[] $comments
 * @property Completeness $completeness
 * @property Download[] $downloads
 * @property FavoriteBook[] $favoriteBooks
 * @property Like[] $likes
 * @property Size $planSize
 * @property User $publisher
 * @property Rating $rating
 * @property Read[] $reads
 * @property Size $realSize
 * @property RecycleBin[] $recycleBins
 * @property Relation $relation0
 * @property Review[] $reviews
 * @property Type $type
 * @property User $user
 * @property ViewHistory[] $viewHistories
 *
 *
 *
 * @property Genre[] $genres
 * @property Tag[] $tags
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @var mixed|null
     */
    public $author;
    /**
     * @var mixed|null
     */

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'is_draft', 'is_perfect', 'is_editable', 'type_id', 'rating_id', 'completeness_id', 'relation_id', 'plan_size_id', 'real_size_id', 'publisher_id', 'is_published', 'access_level_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 500],
            [['cover'], 'string', 'max' => 400],
            [['description'], 'string', 'max' => 2500],
            [['remark'], 'string', 'max' => 6000],
            [['dedication', 'disclaimer'], 'string', 'max' => 1500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['publisher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['publisher_id' => 'id']],
            [['access_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccessLevel::class, 'targetAttribute' => ['access_level_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['type_id' => 'id']],
            [['rating_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rating::class, 'targetAttribute' => ['rating_id' => 'id']],
            [['completeness_id'], 'exist', 'skipOnError' => true, 'targetClass' => Completeness::class, 'targetAttribute' => ['completeness_id' => 'id']],
            [['relation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Relation::class, 'targetAttribute' => ['relation_id' => 'id']],
            [['plan_size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::class, 'targetAttribute' => ['plan_size_id' => 'id']],
            [['real_size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::class, 'targetAttribute' => ['real_size_id' => 'id']],
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
            'created_at' => 'Created At',
            'is_draft' => 'Is Draft',
            'is_perfect' => 'Is Perfect',
            'is_editable' => 'Is Editable',
            'title' => 'Title',
            'cover' => 'Cover',
            'description' => 'Description',
            'remark' => 'Remark',
            'dedication' => 'Dedication',
            'disclaimer' => 'Disclaimer',
            'type_id' => 'Type ID',
            'rating_id' => 'Rating ID',
            'completeness_id' => 'Completeness ID',
            'relation_id' => 'Relation ID',
            'plan_size_id' => 'Plan Size ID',
            'real_size_id' => 'Real Size ID',
            'publisher_id' => 'Publisher ID',
            'is_published' => 'Is Published',
            'access_level_id' => 'Access Level ID',
        ];
    }

    /**
     * Gets query for [[AccessLevel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessLevel()
    {
        return $this->hasOne(AccessLevel::class, ['id' => 'access_level_id']);
    }

    /**
     * Gets query for [[AccessToBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks()
    {
        return $this->hasMany(AccessToBook::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Collections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollections()
    {
        return $this->hasMany(Collection::class, ['id' => 'collection_id'])
                        ->viaTable('book_collection', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Fandoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookFandoms()
    {
        return $this->hasMany(Fandom::class, ['id' => 'fandom_id'])
                        ->viaTable('book_fandom', ['book_id', 'id']);
    }

    /**
     * Gets query for [[Genres]].
     *
     * @return \yii\db\ActiveQuery
     *
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::class, ['id' => 'genre_id'])
                        ->viaTable('book_genre', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookOrigins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookOrigins()
    {
        return $this->hasMany(Origin::class, ['id' => 'origin_id'])
                        ->viaTable('book_origin', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
                        ->viaTable('book_tag', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Chapters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChapters()
    {
        return $this->hasMany(Chapter::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Completeness]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompleteness()
    {
        return $this->hasOne(Completeness::class, ['id' => 'completeness_id']);
    }

    /**
     * Gets query for [[Downloads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDownloads()
    {
        return $this->hasMany(Download::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteBooks() // что-то типа getUsersByFavorite
    {
        return $this->hasMany(FavoriteBook::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[PlanSize]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlanSize()
    {
        return $this->hasOne(Size::class, ['id' => 'plan_size_id']);
    }

    /**
     * Gets query for [[Publisher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(User::class, ['id' => 'publisher_id']);
    }

    /**
     * Gets query for [[Rating]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRating()
    {
        return $this->hasOne(Rating::class, ['id' => 'rating_id']);
    }

    /**
     * Gets query for [[Reads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReads()
    {
        return $this->hasMany(Read::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[RealSize]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRealSize()
    {
        return $this->hasOne(Size::class, ['id' => 'real_size_id']);
    }

    /**
     * Gets query for [[RecycleBins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecycleBins()
    {
        return $this->hasMany(RecycleBin::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Relation0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelation0()
    {
        return $this->hasOne(Relation::class, ['id' => 'relation_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
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

    /**
     * Gets query for [[ViewHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewHistories()
    {
        return $this->hasMany(ViewHistory::class, ['book_id' => 'id']);
    }
}
