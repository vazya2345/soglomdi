<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OylikUderjTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oylik-uderj-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_rasxod')->dropDownList([1=>'Чиқим қилинади', 2=>'Чиқим қилинмайди']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
