<?php

use yii\db\Migration;

/**
 * Class m191208_213243_crerate_bonus_points_configuration_table
 */
class m191208_213243_crerate_bonus_points_configuration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bonus_points_configuration}}', [
            'id' => $this->primaryKey(),
            'min_limit' => $this->integer()->notNull(),
            'max_limit' => $this->integer()->notNull(),
        ]);

        $this->insert('{{%bonus_points_configuration}}', [
            'min_limit' => 10,
            'max_limit' => 115,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bonus_points_configuration}}');
    }
}
