<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $title
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    public function getArticleCount()
    {
        $count = Articles::find()->where('category_id = :id', array(":id" => $this->id))->count();

        return $count;
    }

    public function getViewLink()
    {
        return Url::toRoute(['/site/category-list', 'cat_id' => $this->id]);
    }

    public static function getAll()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

}
