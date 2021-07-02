<?php

use yii\db\Migration;

/**
 * Class m210701_171133_add_fk_link_user
 */
class m210701_171133_add_fk_link_user extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addForeignKey('FK_link_user', '{{%link}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('FK_link_user', '{{%link}}');
    }
}
