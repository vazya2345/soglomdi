<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefSends */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sends-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'refnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sum')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'send_date')->textInput() ?>

    <?= $form->field($model, 'rec_date')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
