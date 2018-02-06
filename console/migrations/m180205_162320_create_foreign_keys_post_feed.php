<?php

use yii\db\Migration;

class m180205_162320_create_foreign_keys_post_feed extends Migration
{

    public function safeUp()
    {
        $this->createIndex(
            'idx-feed-post_id',
            'feed',
            'post_id'
        );
        
        $this->addForeignKey(
            'fk-feed-post_id',
            'feed',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
       $this->dropForeignKey(
            'fk-feed-post_id',
            'feed'
               );
       
       $this->dropIndex(
            'idx-feed-post_id',
            'feed'
        );
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m180205_162320_create_foreign_keys_post_feed cannot be reverted.\n";

      return false;
      }
     */
}
