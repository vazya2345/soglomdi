<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\consultation\models\ConsultationMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-main-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reg_id')->textInput() ?>

    <?= $form->field($model, 'consultation_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
