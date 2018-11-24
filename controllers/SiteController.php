<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

use app\models\Users;
use app\models\Articles;
use app\models\ArticleTag;
use app\models\Comments;


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
                'layout' => 'main-without-sidebar',
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
        $query = Articles::find()->where(['status' => 1])->orderBy('created DESC');
        
        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
        ]);
    }

    public function actionView($slug)
    {
        $model = Articles::find()->where(['slug' => $slug])->one();

        if (is_null($model))
            return $this->goHome();

        $model->viewedCounter();

        $preview = Articles::findOne($id - 1);
        $next = Articles::findOne($id + 1);
        $comments = Comments::find()->where(['article_id' => $model->id])->orderBy('created DESC')->all();

        if (is_null($next))
            $next = Articles::findOne($id - 2);

        if (is_null($preview))
            $preview = Articles::findOne($id + 2);

        $sql = 'status = 1 AND category_id = :cat_id AND id <> :id';
        $likes = Articles::find()->where($sql, [':cat_id' => $model->category_id, ':id' => $model->id])->orderBy('viewed DESC')->limit(6)->all();

        $comment = new Comments();
        $comment->article_id = $model->id;
        
        if (!Yii::$app->user->isGuest)
            $comment->user_id = Yii::$app->user->getId();


        return $this->render('view', [
            'model' => $model,
            'likes' => $likes,
            'next' => $next,
            'preview' => $preview,
            'comment' => $comment,
            'comments' => $comments
        ]);
    }

    public function actionComment()
    {
        $comment = new Comments();

        if ($comment->load(Yii::$app->request->post()) && $comment->save())
        {
            Yii::$app->session->setFlash('success', "Your coment is saved successfully");

            return $this->redirect([$comment->article->getViewLink()]);
        }

        return $this->goBack();

    }

    public function actionCategoryList($cat_id)
    {
        $query = Articles::find()->where('category_id = :cat_id AND status = 1', ['cat_id' => $cat_id]);

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 5
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
            'pageSize' => 5
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
