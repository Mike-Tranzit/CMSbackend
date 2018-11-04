<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%year_subscription}}`.
 */
class m181104_083940_create_year_subscription_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%year_subscription}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer(10)->notNull(),
            'date_create' => $this->dateTime()->notNull(),
            'date_to' => $this->dateTime()->notNull(),
            'count_request' => $this->smallInteger(1)->defaultValue('1'),
            'deleted' => $this->smallInteger(1),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%year_subscription}}');
    }
}
