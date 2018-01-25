<?php

use yii\db\Migration;

class m180121_202449_alter_table_user_drop_index_unique_on_username extends Migration
{

    public function safeUp()
    {
        $this->dropIndex('username', 'user');
    }

    public function safeDown()
    {
        $this->createIndex('username', 'user', 'username', $unique = true);
    }

}
