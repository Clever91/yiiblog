<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Articles;
use app\models\ArticlesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\commons\UploadImage;
use yii\helpers\ArrayHelper;
use app\models\Categories;
use app\models\Tags;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends Controller
{

    const STATUS_ACTIVE = 1;
    const STATUS_NO_ACTIVE = 0;
    const VIEWED_DEFAULT = 0;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles();

        if ($model->load(Yii::$app->request->post())) {

            $model->user_id = Yii::$app->user->id;
            $model->viewed = self::VIEWED_DEFAULT;
            $model->status = self::STATUS_ACTIVE;

            if ($model->saveArticle()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors()); exit();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing <i class="icofont icofont-artichoke"></i>les model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionUploadImage($id) 
    {
        $article = $this->findModel($id);
        $model = new UploadImage($article->image);

        if (Yii::$app->request->isPost)
        {
            if ($model->uploadImage()) {
                $article->saveImage($model->getNewName());
                
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        return $this->render("upload-image", ['model' => $model]);
    }

    public function actionSetCategory($id)
    {
        $model = $this->findModel($id);
        $categories = ArrayHelper::map(Categories::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $category = Yii::$app->request->post('category');
            $model->saveCategory($category);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('set-category', array (
            'model' => $model,
            'categories' => $categories,
        ));
    }

    public function actionSetTags($id)
    {
        $model = Articles::findOne($id);
        $tags = ArrayHelper::map(Tags::find()->all(), 'id', 'title');
        $selectedTags = $model->getSelectedTags();

        if (Yii::$app->request->isPost) {
            
            $tagIds = Yii::$app->request->post('tags');
            $model->deleteCurrectTags();
            $model->saveTags($tagIds);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        

        return $this->render('set-tags', [
            'model' => $model,
            'tags' => $tags,
            'selectedTags' => $selectedTags
        ]);
    }
}