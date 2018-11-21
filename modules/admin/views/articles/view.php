<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Upload Image'), ['upload-image', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Set Category'), ['set-category', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Set Tags'), ['set-tags', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => Yii::t('app', 'Users'),
                'atribute' => 'user_id',
                'value' => $model->user->username
            ],
            [
                'label' => Yii::t('app', 'Categories'),
                'attribute' => 'category_id',
                'value' => $model->category ? $model->category->title : null,
            ],
            'title',
            'description:ntext',
            'content:ntext',
            'status',
            [
                'label' => Yii::t('app', 'Image'),
                'attribute' => 'image',
                'value' => $model->image
            ],
            [
                'label' => Yii::t('app', 'tags'),
                'attribute' => 'tags',
                'value' => $model->getCurrentTags()
            ],
            'viewed',
            'updated',
            'created',
        ],
    ]) ?>

</div>
