<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-comment mr0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-6\">{error}</div>",
                    'labelOptions' => ['class' => 'col-md-2 control-label'],
                ],
            ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'username or email']) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"col-md-offset-1 col-md-5\">{input} {label}</div>\n<div class=\"col-md-6\">{error}</div>",
                ]) ?>

                <div class="form-group">
                    <div class="col-md-offset-6 col-md-6">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
