<?php

use yii\db\Migration;

class m180206_192948_add_index_user_username extends Migration
{
    public function safeUp()
    {
        $this->createIndex(
            'idx-user-username',
            'user',
            'username'
        );
    }

    public function safeDown()
    {
        $this->dropIndex(
            'idx-user-username',
            'user'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180206_192948_add_index_user_username cannot be reverted.\n";

        return false;
    }
    */
}
