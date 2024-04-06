<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "character_origin".
 *
 * @property int $id
 * @property int|null $character_id
 * @property int|null $origin_id
 *
 * @property Character $character
 * @property Origin $origin
 */
class CharacterOrigin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'character_origin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['character_id', 'origin_id'], 'integer'],
            [['character_id'], 'exist', 'skipOnError' => true, 'targetClass' => Character::class, 'targetAttribute' => ['character_id' => 'id']],
            [['origin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Origin::class, 'targetAttribute' => ['origin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'character_id' => 'Character ID',
            'origin_id' => 'Origin ID',
        ];
    }

    /**
     * Gets query for [[Character]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacter()
    {
        return $this->hasOne(Character::class, ['id' => 'character_id']);
    }

    /**
     * Gets query for [[Origin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrigin()
    {
        return $this->hasOne(Origin::class, ['id' => 'origin_id']);
    }
}
