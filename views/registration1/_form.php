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

    <?= $form->field($model, 'analiz_id')->textInput() ?>

    <?= $form->field($model, 'sum_amount')->textInput() ?>

    <?= $form->field($model, 'sum_cash')->textInput() ?>

    <?= $form->field($model, 'sum_plastik')->textInput() ?>

    <?= $form->field($model, 'sum_debt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
