<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%zernovoz.invoices}}`.
 */
class m181104_083545_create_invoices_table extends Migration
{
    /**
     * @inheritdoc
     */
    
    public function safeUp()
    {

        $tableName = $this->db->tablePrefix . 'zernovoz.invoices';

        $tableSchema = $this->db->getTableSchema($tableName, true);

        if ($tableSchema === null) {

            $this->createTable('{{%zernovoz.invoices}}', [
                'id' => $this->primaryKey()->notNull(),
                'datecreate' => $this->dateTime()->notNull(),
                'status' => $this->integer(11)->notNull(),
                'amount' => $this->decimal(12)->notNull(),
                'dateresult' => $this->dateTime(),
                'userIdCreate' => $this->integer(11)->notNull(),
                'methodPay' => $this->integer(11)->notNull(),
                'orderId' => $this->string(11)->notNull(),
                'amountIncome' => $this->decimal(12)->notNull()->defaultValue('0.00'),
            ]);

        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%invoices}}');
    }
}
