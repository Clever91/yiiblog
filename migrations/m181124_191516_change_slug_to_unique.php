<?php

use yii\db\Migration;

/**
 * Class m181124_191516_change_slug_to_unique
 */
class m181124_191516_change_slug_to_unique extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('articles', 'slug', $this->string(255)->unique()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //
    }
}
