<?php

use \yii\db\Migration;


class m190124_110201_add_table_link extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull(),
            'description' => $this->string(255),
            'link' => $this->string(255)->notNull(),
            'token' => $this->string(255),
            'ttl' => $this->integer()->notNull()->defaultValue(0),
            'hit_limit' => $this->smallInteger()->notNull()->defaultValue(0),
            'status' => "ENUM('active', 'stopped', 'expired', 'deleted') DEFAULT 'stopped'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%link}}');
    }
}
