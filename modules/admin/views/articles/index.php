<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Articles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Articles'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            'description:ntext',
            [
                'label' => Yii::t('app', 'Users'),
                'attribute' => 'user_id',
                'value' => function($data) {
                    return $data->user->username;
                }
            ],
            [
                'label' => Yii::t('app', 'Categories'),
                'attribute' => 'user_id',
                'value' => function($data) {
                    return ($data->category) ? $data->category->title : null;
                }
            ],
            //'content:ntext',
            [
                'label' => Yii::t('app', 'Status'),
                'attribute' => 'status',
                'filter' => Articles::getStatus(),
                'value' => function($data) {
                    return $data->getStatusName();
                },
            ],
            [
                'label' => Yii::t('app', 'Image'),
                'attribute' => 'image',
                'format' => 'html',
                'value' => function($data) {
                    return Html::img($data->getImage(), ['width' => 200]);
                }
            ],
            //'viewed',
            //'updated',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
