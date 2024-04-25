<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $login
 * @property string|null $password
 * @property string|null $salt
 * @property string|null $email
 * @property string|null $avatar
 * @property string|null $registered_at
 * @property int|null $is_banned
 * @property string|null $banned_until
 * @property string|null $about
 * @property string|null $url
 * @property int|null $is_publisher
 * @property string|null $official_website
 * @property int|null $is_admin
 * @property int|null $is_moderator
 * @property int|null $theme_id
 *
 * @property AccessLevel[] $accessLevels
 * @property AccessToBook[] $accessToBooks
 * @property AccessToBook[] $accessToBooks0
 * @property AccessToBook[] $accessToBooks1
 * @property AccessToBook[] $accessToBooks2
 * @property AccessToBook[] $accessToBooks3
 * @property AccessToBook[] $accessToBooks4
 * @property AccessToBook[] $accessToBooks5
 * @property ActivityRate[] $activityRates
 * @property Blacklist[] $blacklists
 * @property Blacklist[] $blacklists0
 * @property Book[] $books
 * @property Book[] $books0
 * @property Comment[] $comments
 * @property Complaint[] $complaints
 * @property Complaint[] $complaints0
 * @property CreatingActivity $creatingActivity
 * @property Download[] $downloads
 * @property Fandom[] $fandoms
 * @property FavoriteBook[] $favoriteBooks
 * @property FavoriteFandom[] $favoriteFandoms
 * @property Followers[] $followers
 * @property Followers[] $followers0
 * @property Like[] $likes
 * @property Origin[] $origins
 * @property Read[] $reads
 * @property RecycleBin[] $recycleBins
 * @property Review[] $reviews
 * @property TagRequest[] $tagRequests
 * @property TagRequest[] $tagRequests0
 * @property UserAccess[] $userAccesses
 * @property UserAccess[] $userAccesses0
 * @property UserAchievements[] $userAchievements
 * @property ViewHistory[] $viewHistories
 * @property Visits[] $visits
 * @property Visits[] $visits0
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $auth_key = 'some key';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registered_at', 'banned_until'], 'safe'],
            [['is_banned', 'is_publisher', 'is_admin', 'is_moderator'], 'integer'],
            [['login'], 'string', 'max' => 200],
            [['password'], 'string', 'max' => 100],
            [['salt'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 340],
            [['avatar'], 'string', 'max' => 400],
            [['about'], 'string', 'max' => 2500],
            [['url'], 'string', 'max' => 60],
            [['official_website'], 'string', 'max' => 255],

            ['login', 'unique', 'targetClass' => User::class,  'message' => 'Этот логин уже занят'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'salt' => 'Salt',
            'email' => 'Email',
            'avatar' => 'Avatar',
            'registered_at' => 'Registered At',
            'is_banned' => 'Is Banned',
            'banned_until' => 'Banned Until',
            'about' => 'About',
            'url' => 'Url',
            'is_publisher' => 'Is Publisher',
            'official_website' => 'Official Website',
            'is_admin' => 'Is Admin',
            'is_moderator' => 'Is Moderator',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }


    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }




    public function getTheme() {
        return $this->hasOne(Theme::class, ['id' => 'theme_id']);
    }




    /**
     * Gets query for [[AccessLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessLevels()
    {
        return $this->hasMany(AccessLevel::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks()
    {
        return $this->hasMany(AccessToBook::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks0()
    {
        return $this->hasMany(AccessToBook::class, ['co_author_1_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks1()
    {
        return $this->hasMany(AccessToBook::class, ['co_author_2_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks2()
    {
        return $this->hasMany(AccessToBook::class, ['beta_1_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks3]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks3()
    {
        return $this->hasMany(AccessToBook::class, ['beta_2_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks4]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks4()
    {
        return $this->hasMany(AccessToBook::class, ['gamma_1_id' => 'id']);
    }

    /**
     * Gets query for [[AccessToBooks5]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessToBooks5()
    {
        return $this->hasMany(AccessToBook::class, ['gamma_2_id' => 'id']);
    }

    /**
     * Gets query for [[ActivityRates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivityRates()
    {
        return $this->hasMany(ActivityRate::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Blacklists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklists()
    {
        return $this->hasMany(Blacklist::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Blacklists0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlacklists0()
    {
        return $this->hasMany(Blacklist::class, ['listed_user_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Books0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks0()
    {
        return $this->hasMany(Book::class, ['publisher_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Complaints]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints()
    {
        return $this->hasMany(Complaint::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Complaints0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComplaints0()
    {
        return $this->hasMany(Complaint::class, ['resolving_moderator_id' => 'id']);
    }

    /**
     * Gets query for [[CreatingActivity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatingActivity()
    {
        return $this->hasOne(CreatingActivity::class, ['id' => 'id']);
    }

    /**
     * Gets query for [[Downloads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDownloads()
    {
        return $this->hasMany(Download::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Fandoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFandoms()
    {
        return $this->hasMany(Fandom::class, ['this_creator_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteBooks()
    {
        return $this->hasMany(FavoriteBook::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[FavoriteFandoms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteFandoms()
    {
        return $this->hasMany(FavoriteFandom::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Followers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Followers::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Followers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFollowers0()
    {
        return $this->hasMany(Followers::class, ['follower_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Like::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Origins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigins()
    {
        return $this->hasMany(Origin::class, ['this_creator_id' => 'id']);
    }

    /**
     * Gets query for [[Reads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReads()
    {
        return $this->hasMany(Read::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[RecycleBins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecycleBins()
    {
        return $this->hasMany(RecycleBin::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TagRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagRequests()
    {
        return $this->hasMany(TagRequest::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TagRequests0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagRequests0()
    {
        return $this->hasMany(TagRequest::class, ['approving_moderator_id' => 'id']);
    }

    /**
     * Gets query for [[UserAccesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccesses()
    {
        return $this->hasMany(UserAccess::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserAccesses0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccesses0()
    {
        return $this->hasMany(UserAccess::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[UserAchievements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserAchievements()
    {
        return $this->hasMany(UserAchievements::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ViewHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViewHistories()
    {
        return $this->hasMany(ViewHistory::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Visits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visits::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Visits0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisits0()
    {
        return $this->hasMany(Visits::class, ['visitor_id' => 'id']);
    }
}
