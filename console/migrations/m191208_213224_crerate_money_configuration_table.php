<?php

use yii\db\Migration;

/**
 * Class m191208_213224_crerate_money_configuration_table
 */
class m191208_213224_crerate_money_configuration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%money_configuration}}', [
            'id' => $this->primaryKey(),
            'left_amount' => $this->integer()->notNull(),
            'min_limit' => $this->integer()->notNull(),
            'max_limit' => $this->integer()->notNull(),
            'conversion_ratio' => $this->float()->notNull()->comment('money amount will be multiplied on that value on conversion'),
        ]);

        $this->insert('{{%money_configuration}}', [
            'left_amount' => 1000,
            'min_limit' => 2,
            'max_limit' => 23,
            'conversion_ratio' => 2.5,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%money_configuration}}');
    }
}
