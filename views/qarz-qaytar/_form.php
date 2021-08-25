<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QarzQaytar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qarz-qaytar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reg_id')->textInput() ?>

    <?= $form->field($model, 'summa_plasitk')->textInput() ?>

    <?= $form->field($model, 'summa_naqd')->textInput() ?>

    <?= $form->field($model, 'qaytargan_vaqt')->textInput() ?>

    <?= $form->field($model, 'kassir_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
