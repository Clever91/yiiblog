<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-comment mr0">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-md-8">{image}</div><div class="col-md-2">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
