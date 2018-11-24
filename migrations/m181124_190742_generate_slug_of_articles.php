<?php

use yii\db\Migration;
use app\models\Articles;

/**
 * Class m181124_190742_generate_slug_of_articles
 */
class m181124_190742_generate_slug_of_articles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $models = Articles::find()->all();

        foreach ($models as $model) 
        {
            $model->slug .= "_" . $model->id;
            $model->save(false);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //
    }

}
