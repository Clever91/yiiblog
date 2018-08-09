<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m180303_182812_create_articles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'image' => $this->string(50)->defaultValue(null),
            'viewed' => $this->integer()->defaultValue(0),
            'updated' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // create index for column 'user_id'
        $this->createIndex(
            'idx-a-articles-user_id',
            'articles',
            'user_id'
        );

        // add foreign key for table 'users'
        $this->addForeignKey(
            'fk-a-articles-user_id',
            'articles',
            'user_id',
            'users',
            'id',
            'RESTRICT'
        );

        // create index for column 'category_id'
        $this->createIndex(
            'idx-a-articles-category_id',
            'articles',
            'category_id'
        );

        // add foreign key for table 'category_id'
        $this->addForeignKey(
            'fk-a-articles-category_id',
            'articles',
            'user_id',
            'categories',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-a-articles-user_id');
        $this->dropIndex('idx-a-articles-user_id');

        $this->dropForeignKey('fk-a-articles-category_id');
        $this->dropIndex('idx-a-articles-category_id');

        $this->dropTable('articles');
    }
}
