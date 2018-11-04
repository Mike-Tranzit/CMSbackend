<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tarif}}`.
 */
class m181104_083825_create_tarif_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%tarif}}', [
            'id' => $this->primaryKey()->notNull(),
            'name' => $this->string(50),
            'value' => $this->integer(10),
            'count_month' => $this->integer(5),
            'title' => $this->string(255),
            'value_text' => $this->string(255),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%tarif}}');
    }
}
