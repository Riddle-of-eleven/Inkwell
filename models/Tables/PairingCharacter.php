<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "pairing_character".
 *
 * @property int $id
 * @property int $pairing_id
 * @property int $character_id
 * @property int $order
 *
 * @property Character $character
 * @property Pairing $pairing
 */
class PairingCharacter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pairing_character';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pairing_id', 'character_id'], 'required'],
            [['pairing_id', 'character_id', 'order'], 'integer'],
            [['character_id'], 'exist', 'skipOnError' => true, 'targetClass' => Character::class, 'targetAttribute' => ['character_id' => 'id']],
            [['pairing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pairing::class, 'targetAttribute' => ['pairing_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pairing_id' => 'Pairing ID',
            'character_id' => 'Character ID',
            'order' => 'Order',
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
     * Gets query for [[Pairing]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPairing()
    {
        return $this->hasOne(Pairing::class, ['id' => 'pairing_id']);
    }
}
