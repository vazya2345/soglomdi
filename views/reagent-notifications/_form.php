<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReagentNotifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reagent-notifications-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reagent_id')->textInput() ?>

    <?= $form->field($model, 'filial_id')->textInput() ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
