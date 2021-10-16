<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneySend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-send-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'send_user')->textInput() ?>

    <?= $form->field($model, 'rec_user')->textInput() ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'send_date')->textInput() ?>

    <?= $form->field($model, 'rec_date')->textInput() ?>

    <?= $form->field($model, 'desc')->textInput() ?>

    <?= $form->field($model, 'send_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
