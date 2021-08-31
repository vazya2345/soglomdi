<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Reagent;
/* @var $this yii\web\View */
/* @var $model app\models\ReagentInput */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reagent-input-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reagent_id')->dropDownList(Reagent::getAll()) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    

    <div class="form-group field-reagentinput-value required">
        <label class="control-label" for="reagentinput-value">Янги нархи</label>
        <?= Html::input('number','narxyangi','', ['class'=>'form-control', 'id'=>'reagentinput-narx'])?>

        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
