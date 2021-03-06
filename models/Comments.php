<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $article_id
 * @property int $status
 * @property string $created
 *
 * @property Users $user
 */
class Comments extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'user_id', 'article_id'], 'required'],
            [['user_id', 'article_id'], 'integer'],
            [['created'], 'safe'],
            [['text'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'user_id' => Yii::t('app', 'User ID'),
            'article_id' => Yii::t('app', 'Article ID'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Articles::className(), ['id' => 'article_id']);
    }

    public function afterSave()
    {
        if ($this->isNewRecord)
        {
            $this->status = self::STATUS_ACTIVE;
            $this->created = date("Y-m-d H:m:i");
        }
    }

    public function getCreated()
    {
        return Yii::$app->formatter->asDatetime($this->created, 'long');
    }


    public function getStatusName()
    {
        return self::getStatus()[$this->status];
    }

    public static function getStatus()
    {
        return [
            self::STATUS_ACTIVE => "Active",
            self::STATUS_NO_ACTIVE => "No Active",
        ];
    }

}
