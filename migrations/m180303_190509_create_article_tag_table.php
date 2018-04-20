<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tag`.
 */
class m180303_190509_create_article_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_tag', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
        ]);

        // create index for column 'article_id'
        $this->createIndex(
            'idx-at-article-article_id',
            'article_tag',
            'article_id'
        );

        // add foreign key for table 'articles'
        $this->addForeignKey(
            'fk-at-article-article_id',
            'article_tag',
            'article_id',
            'articles',
            'id',
            'CASCADE'
        );

        // create index for column 'tag_id'
        $this->createIndex(
            'idx-at-tag-tag_id',
            'article_tag',
            'tag_id'
        );

        // add foreign key for table 'tags'
        $this->addForeignKey(
            'fk-at-tag-tag_id',
            'article_tag',
            'tag_id',
            'tags',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_tag');
    }
}
