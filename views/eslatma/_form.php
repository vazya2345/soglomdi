<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Eslatma */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="eslatma-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'eslatma_text')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
