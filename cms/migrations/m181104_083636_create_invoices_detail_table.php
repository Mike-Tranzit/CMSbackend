<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices_detail}}`.
 */
class m181104_083636_create_invoices_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%invoices_detail}}', [
            'id' => $this->primaryKey()->notNull(),
            'date_create' => $this->dateTime(),
            'user_id' => $this->integer(11),
            'date_old' => $this->dateTime(),
            'date_new' => $this->dateTime(),
            'sub_active_old' => $this->integer(4),
            'sub_active_new' => $this->integer(4),
            'invId' => $this->integer(10),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoices_detail}}');
    }
}
