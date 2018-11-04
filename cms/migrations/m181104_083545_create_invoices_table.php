<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%invoices}}`.
 */
class m181104_083545_create_invoices_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%invoices}}', [
            'id' => $this->primaryKey()->notNull(),
            'datecreate' => $this->dateTime()->notNull(),
            'status' => $this->integer(11)->notNull(),
            'amount' => $this->notNull(),
            'dateresult' => $this->dateTime(),
            'userIdCreate' => $this->integer(11)->notNull(),
            'methodPay' => $this->integer(11)->notNull(),
            'orderId' => $this->string(11)->notNull(),
            'amountIncome' => $this->notNull()->defaultValue('0.00'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoices}}');
    }
}
