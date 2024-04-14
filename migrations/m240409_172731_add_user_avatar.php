<?php

use yii\db\Migration;

/**
 * Class m240409_172731_add_user_avatar
 */
class m240409_172731_add_user_avatar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240409_172731_add_user_avatar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240409_172731_add_user_avatar cannot be reverted.\n";

        return false;
    }
    */
}
