<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegAnalizs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reg-analizs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reg_id')->textInput() ?>

    <?= $form->field($model, 'analiz_id')->textInput() ?>

    <?= $form->field($model, 'summa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
