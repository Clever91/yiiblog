<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180303_182707_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string(20)->notNull()->unique(),
            'password' => $this->string(64)->notNull(),
            'is_ban' => $this->tinyInteger(1)->defaultValue(0),
            'name' => $this->string(50)->defaultValue(null),
            'photo' => $this->string(20)->defaultValue(null),
            'email' => $this->string()->defaultValue(null),
            'is_admin' => $this->tinyInteger(1)->defaultValue(0),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
