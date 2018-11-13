<?php

use yii\db\Migration;

/**
 * Class m181113_015920_alter_table_users_add_uid
 */
class m181113_015920_alter_table_users_add_uid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'uid', $this->integer(11));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'uid');
    }
}
