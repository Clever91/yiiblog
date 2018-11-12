<?php

namespace app\models;

use Yii;
use app\commons\UploadImage;
use yii\helpers\Url;
use app\models\Categories;
use app\models\Tags;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property int $status
 * @property string $image
 * @property int $viewed
 * @property string $updated
 * @property string $created
 *
 * @property ArticleTag[] $articleTags
 */
class Articles extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;
    const VIEWED_DEFAULT = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'description', 'content'], 'required'],
            [['user_id', 'category_id', 'viewed', 'status'], 'integer'],
            [['description', 'content'], 'string'],
            [['updated', 'created'], 'safe'],
            [['updated', 'created'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['updated', 'created'], 'default', 'value' => date('Y-m-d H:i:s')],
            // [['viewed'], 'default', 'value' => 0],
            // [['status'], 'default', 'value' => 1],
            [['title'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'status' => Yii::t('app', 'Status'),
            'image' => Yii::t('app', 'Image'),
            'viewed' => Yii::t('app', 'Viewed'),
            'updated' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    public static function getPopular($limit = 3)
    {
        return Articles::find()->orderBy("viewed DESC")->limit($limit)->all();
    }

    public static function getLast($limit = 4)
    {
        return Articles::find()->orderBy("created DESC")->limit($limit)->all();
    }

    public static function getCategories()
    {
        return Categories::find()->all();
    }

    // ~~~~~~~~~~~~~~~~~~~~~ Save Functions ~~~~~~~~~~~~~~~~~~~~~


    public function saveArticle()
    {
        $this->user_id = Yii::$app->user->identity->id;
        return $this->save();
    }

    public function saveCategory($category_id)
    {
        $this->category_id = $category_id;
        $this->save(false);
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        $this->save(false);
    }

    public function saveTags($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $this->saveTag($id);
            }
        }
    }

    private function saveTag($id)
    {
        $tag = Tags::findOne($id);
        if ($tag) {
            $this->link('tags', $tag);
            // $articleTag = new ArticleTag();
            // $articleTag->article_id = $this->id;
            // $articleTag->tag_id = $tag->id;
            // $articleTag->save();
        }
    }


    // ~~~~~~~~~~~~~~~~~~~~~ Get Functions ~~~~~~~~~~~~~~~~~~~~~

    public function getCreated()
    {
        return Yii::$app->formatter->asDate($this->created, 'long');
    }

    public function getSelectedTags()
    {
        $tags = $this->getTags()->select('id')->asArray()->all();

        return ArrayHelper::getColumn($tags, 'id');
    }

    public function getCurrentTags()
    {
        $tags = $this->getTags()->all();

        if (is_array($tags) && count($tags)) {
            $tagNames = '';
            foreach ($tags as $tag) {
                $tagNames .= $tag->title . ' ';
            }

            return $tagNames;
        }

        return null;

    }

    public function getImage()
    {
        $model = new UploadImage($this->image);

        return $model->getImageWithPath();
    }

    public function getStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_NO_ACTIVE => 'No Active'
        ];
    }

    // ~~~~~~~~~~~~~~~~~~~~~ Delete Function ~~~~~~~~~~~~~~~~~~~~~


    public function deleteCurrectTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }

    // ~~~~~~~~~~~~~~~~~~~~~ Set Function ~~~~~~~~~~~~~~~~~~~~~

    public function setStatusActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function setStatusNoActive()
    {
        $this->status = self::STATUS_NO_ACTIVE;
    }

    public function setDefaultVieved()
    {
        $this->viewed = self::VIEWED_DEFAULT;
    }


    // ~~~~~~~~~~~~~~~~~~~~~ Relations Start ~~~~~~~~~~~~~~~~~~~~~


    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getViewLink()
    {
        return Url::toRoute(['/site/view', 'id' => $this->id]);
    }


    // ~~~~~~~~~~~~~~~~~~~~~ Extent Functions ~~~~~~~~~~~~~~~~~~~~~


    public function beforeDelete() 
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $model = new UploadImage($this->image);
        $model->deleteImage();

        return true;
    }

    public function beforeSave($insert) {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->updated = date("Y-m-d H:i:s");

        return true;
    }
}
