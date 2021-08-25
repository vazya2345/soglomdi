<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FqSends */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fq-sends-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fq_id')->textInput() ?>

    <?= $form->field($model, 'sum')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'send_date')->textInput() ?>

    <?= $form->field($model, 'rec_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
