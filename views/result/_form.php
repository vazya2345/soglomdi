<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Result */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="result-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'main_id')->textInput() ?>

    <?= $form->field($model, 'analiz_id')->textInput() ?>

    <?= $form->field($model, 'pokaz_id')->textInput() ?>

    <?= $form->field($model, 'reslut_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'result_answer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
