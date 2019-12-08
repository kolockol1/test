<?php

use yii\db\Migration;

/**
 * Class m191208_213910_alter_user_prizes_table
 */
class m191208_213910_alter_user_prizes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user_prizes}}', 'prize_amount', $this->float()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user_prizes}}', 'prize_amount', $this->integer()->notNull());
    }
}
