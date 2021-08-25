<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reagent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reagent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qoldiq')->textInput() ?>

    <?= $form->field($model, 'martalik')->dropDownList(['1'=>'Бир марталик', '2'=>'Икки марталик']) ?>

    <?= $form->field($model, 'add1')->textInput(['maxlength' => true, 'value' => 'Изоҳ']) ?>

    <?= $form->field($model, 'check')->dropDownList(['1'=>'Оддий', '7'=>'Бир марталик восита']) ?>

    <?= $form->field($model, 'price')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'notific_count')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'notific_filial')->textInput(['type'=>'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
