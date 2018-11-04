<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_docs}}`.
 */
class m181104_083847_create_user_docs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%user_docs}}', [
            'user_id' => $this->primaryKey()->notNull(),
            'company_name' => $this->string(255)->notNull(),
            'inn' => $this->string(255)->notNull(),
            'place' => $this->string(255),
            'kpp' => $this->string(255),
            'ogrn' => $this->string(255),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_docs}}');
    }
}
