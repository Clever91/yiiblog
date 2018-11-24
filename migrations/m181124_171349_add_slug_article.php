<?php

use yii\db\Migration;

/**
 * Class m181124_171349_add_slug_article
 */
class m181124_171349_add_slug_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('articles', 'slug', $this->string(255)->notNull()->after('title')->defaultValue("default_slug"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles', 'slug');
    }
}
