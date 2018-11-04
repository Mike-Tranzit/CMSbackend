<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscriptions_active}}`.
 */
class m181104_084025_create_subscriptions_active_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%subscriptions_active}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'requests_left' => $this->integer(11)->notNull(),
            'permanent' => $this->integer(11)->notNull(),
            'plan_id' => $this->integer(11)->notNull(),
            'add_date' => $this->dateTime(),
            'burnout_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscriptions_active}}');
    }
}
