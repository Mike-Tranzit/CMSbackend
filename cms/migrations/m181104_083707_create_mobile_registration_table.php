<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mobile_registration}}`.
 */
class m181104_083707_create_mobile_registration_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%mobile_registration}}', [
            'id' => $this->primaryKey()->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'last_sms_date' => $this->dateTime(),
            'activation_code' => $this->string(6)->notNull(),
            'registration_date' => $this->notNull()->defaultValue('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%mobile_registration}}');
    }
}
