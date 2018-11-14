<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m181104_083725_create_orders_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'zernovoz.orders';

        $tableSchema = $this->db->getTableSchema($tableName, true);

        if ($tableSchema === null) {
            $this->createTable('{{%zernovoz.orders}}', [
                'id' => $this->primaryKey()->notNull(),
                'tarif_id' => $this->integer(3),
                'count_request' => $this->integer(3),
                'count_month' => $this->integer(3),
                'count_weeks' => $this->integer(3),
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
