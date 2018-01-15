<?php

use yii\db\Migration;

class m180109_171738_alter_table_post_add_column_complaints extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%post}}', 'complaints', $this->integer());
    }

    public function down()
    {
        $this->addColumn('{{$post}}', 'complaints');
    }

}
