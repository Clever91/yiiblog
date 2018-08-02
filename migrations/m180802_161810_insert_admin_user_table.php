<?php

use yii\db\Migration;

/**
 * Class m180802_161810_insert_admin_user_table
 */
class m180802_161810_insert_admin_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('users', [
            'username' => 'admin',
            'password' => sha1('admin'),
            'is_admin' => 1,
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete("users", ['id' => 1]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180802_161810_insert_admin_user_table cannot be reverted.\n";

        return false;
    }
    */
}
