<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'client_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'sum_amount')->textInput() ?>

    <?= $form->field($model, 'sum_cash')->textInput() ?>

    <?= $form->field($model, 'sum_plastik')->textInput() ?>

    <?= $form->field($model, 'sum_debt')->textInput() ?>

    <?= $form->field($model, 'ref_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'natija_input')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skidka')->textInput() ?>

    <?= $form->field($model, 'other')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'change_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
