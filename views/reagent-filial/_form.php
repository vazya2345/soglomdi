<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReagentFilial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reagent-filial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filial_id')->textInput() ?>

    <?= $form->field($model, 'reagent_id')->textInput() ?>

    <?= $form->field($model, 'qoldiq')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
