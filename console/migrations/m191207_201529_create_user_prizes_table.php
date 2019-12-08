<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_prizes}}`.
 */
class m191207_201529_create_user_prizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_prizes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'date_create' => $this->dateTime()->notNull(),
            'prize_type' => $this->integer()->notNull(),
            'prize_amount' => $this->float()->notNull(),
            'prize_status' => $this->smallInteger()->notNull(),
        ]);

        $this->createIndex('id_user_id', '{{%user_prizes}}', ['id', 'user_id',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('id_user_id', '{{%user_prizes}}');
        $this->dropTable('{{%user_prizes}}');
    }
}
