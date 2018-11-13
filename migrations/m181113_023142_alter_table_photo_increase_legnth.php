<?php

use yii\db\Migration;

/**
 * Class m181113_023142_alter_table_photo_increase_legnth
 */
class m181113_023142_alter_table_photo_increase_legnth extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('users', 'photo', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'photo', $this->string(20));
    }
    
}
