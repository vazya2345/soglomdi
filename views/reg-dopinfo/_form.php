<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegDopinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reg-dopinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reg_id')->textInput() ?>

    <?= $form->field($model, 'indikator_id')->textInput() ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
