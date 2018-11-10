<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $id
 * @property int $tag_id
 * @property int $article_id
 *
 * @property Articles $article
 * @property Tags $tag
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'article_id'], 'required'],
            [['tag_id', 'article_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Articles::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'article_id' => Yii::t('app', 'Article ID'),
        ];
    }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getArticle()
    // {
    //     return $this->hasOne(Articles::className(), ['id' => 'article_id']);
    // }

    // /**
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getTag()
    // {
    //     return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    // }
}
