<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OylikShakl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oylik-shakl-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'period')->textInput() ?>

    <?= $form->field($model, 'oylik_hodimlar_id')->textInput() ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fil_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lavozim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summa')->textInput() ?>

    <?= $form->field($model, 'shakl_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
