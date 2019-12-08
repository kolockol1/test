<?php

use yii\db\Migration;

/**
 * Class m191208_191613_alter_user_prizes_table
 */
class m191208_191613_alter_user_prizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_prizes}}', 'material_item_id', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_prizes}}', 'material_item_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191208_191613_alter_user_prizes_table cannot be reverted.\n";

        return false;
    }
    */
}
