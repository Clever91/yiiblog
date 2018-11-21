<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'name' => "description"]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'name' => "content"]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryData, ['prompt' => 'Select...']) ?>

    <?= $form->field($model, 'status')->dropDownList($statusData, ['prompt' => 'Select...']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
