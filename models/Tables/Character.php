<?php

namespace app\models\Tables;

/**
 * This is the model class for table "character".
 *
 * @property int $id
 * @property string|null $full_name
 * @property int|null $fandom_id
 * @property int|null $project_id
 *
 * @property CharacterOrigin[] $characterOrigins
 * @property Fandom $fandom
 */
class Character extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'character';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fandom_id', 'project_id'], 'integer'],
            [['full_name'], 'string', 'max' => 300],
            [['fandom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fandom::class, 'targetAttribute' => ['fandom_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'fandom_id' => 'Fandom ID',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * Gets query for [[CharacterOrigins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacterOrigins()
    {
        return $this->hasMany(CharacterOrigin::class, ['character_id' => 'id']);
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
}
