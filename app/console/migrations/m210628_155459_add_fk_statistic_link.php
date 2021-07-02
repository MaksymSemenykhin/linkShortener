<?php

use yii\db\Migration;

/**
 * Class m210628_155459_add_fk_statistic_link
 */
class m210628_155459_add_fk_statistic_link extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addForeignKey('FK_statistic_link', '{{%statistic}}', 'link_id', '{{%link}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('FK_statistic_link', '{{%statistic}}');
    }
}
