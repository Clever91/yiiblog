<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
// use app\models\ContactForm;
use app\models\Users;
use app\models\Articles;
use app\models\ArticleTag;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $query = Articles::find()->where(['status' => 1]);
        
        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 1
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    public function actionView($id)
    {
        $model = Articles::findOne($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionCategoryList($cat_id)
    {
        $query = Articles::find()->where('category_id = :cat_id AND status = 1', ['cat_id' => $cat_id]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 1
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('list', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    public function actionTagList($tag_id)
    {

        $articles = ArticleTag::find()->where('tag_id = :id', [':id' => $tag_id])->select('article_id')->asArray()->all();

        $ids = ArrayHelper::getColumn($articles, 'article_id');

        $query = Articles::find()->where(['id' => $ids, 'status' => 1]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 1
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('list', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }
}
