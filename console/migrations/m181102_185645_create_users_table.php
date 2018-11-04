<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m181102_185645_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->string(255),
            'deleted' => $this->integer(1),
            'updated_at' => $this->dateTime()->notNull(),
            'arrived' => $this->smallInteger(1)->notNull()->comment('Status'),
            'loadingDate' => $this->dateTime()->notNull(),
            'role_id' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
