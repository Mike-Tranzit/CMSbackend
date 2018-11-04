<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m181104_083854_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey()->notNull(),
            'login' => $this->string(50),
            'password' => $this->string(255),
            'last_in' => $this->dateTime(),
            'name' => $this->string(255),
            'admin' => $this->smallInteger(4)->defaultValue('1'),
            'activ' => $this->integer(1)->defaultValue('1')->comment('Вход с СМС, 0 - да, 1 - нет'),
            'generate' => $this->string(255),
            'isProvider' => $this->integer(10)->comment('0 - клиент, 1 - Порт-Транзит, 2 - Южные технологии'),
            'role' => $this->integer(1)->defaultValue('1')->comment('1- обычный пользователь, 2-ЮТ, 3-Мы'),
            'confirm' => $this->integer(1),
            'company' => $this->string(255),
            'email' => $this->string(255),
            'skype' => $this->string(255),
            'occupation' => $this->integer(2)->notNull(),
            'status_id' => $this->integer(11)->notNull()->defaultValue('2')->comment('vip status = 2'),
            'balance' => $this->notNull()->defaultValue('0'),
            'status_expiry' => $this->dateTime()->defaultValue('2016-08-01 00:00:00'),
            'show_nat_services' => $this->integer(1)->notNull()->defaultValue('1'),
            'working_with_nds' => $this->integer(1)->notNull(),
            'company_id' => $this->integer(10)->notNull(),
            'place' => $this->string(255),
            'place_code' => $this->string(13),
            'region' => $this->string(255),
            'region_code' => $this->string(13),
            'rating' => $this->notNull(),
            'has_docs' => $this->integer(1)->notNull(),
            'forum_blocked' => $this->integer(1)->notNull(),
            'forum_block_expiry' => $this->dateTime(),
            'token_http' => $this->string(256)->notNull(),
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
