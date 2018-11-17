<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Comments;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comments-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'user_id',
                'label' => 'Users',
                'value' => function($data) {
                    return $data->user->username;
                }
            ],
            [
                'attribute' => 'article_id',
                'label' => 'Articles',
                'value' => function($data) {
                    return $data->article->title;
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'filter' => Comments::getStatus(),
                'value' => function($data) {
                    return $data->getStatusName();
                },
            ],
            // 'text',
            [
                'attribute' => 'text',
                'label' => 'Text'
            ],
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
