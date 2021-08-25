<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InpTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inp-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'add1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ord')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
