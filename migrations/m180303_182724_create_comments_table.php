<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m180303_182724_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue(1),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // // create index for column 'article_id'
        // $this->createIndex(
        //     'idx-c-article-article_id',
        //     'comments',
        //     'article_id'
        // );

        // // add foreign key for table 'articles'
        // $this->addForeignKey(
        //     'fk-c-article-article_id',
        //     'comments',
        //     'article_id',
        //     'articles',
        //     'id',
        //     'CASCADE'
        // );

        // create index for column 'user_id'
        $this->createIndex(
            'idx-c-users-user_id',
            'comments',
            'user_id'
        );

        // add foreign key for table 'users'
        $this->addForeignKey(
            'fk-c-users-user_id',
            'comments',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropForeignKey("fk-c-article-article_id");
        // $this->dropForeignKey("fk-c-users-user_id");
        // $this->dropIndex("idx-c-article-article_id");
        // $this->dropIndex("idx-c-users-user_id");
        $this->dropTable('comments');
    }
}
