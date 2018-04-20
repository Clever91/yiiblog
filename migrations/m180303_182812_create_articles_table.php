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
            'updated' => $this->timestamp()->defaultValue(null),//->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('articles');
    }
}
