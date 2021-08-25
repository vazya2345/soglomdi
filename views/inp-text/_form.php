<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InpTypes;
/* @var $this yii\web\View */
/* @var $model app\models\InpText */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inp-text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'inptype_id')->dropDownList(InpTypes::getAll()) ?>

    <?= $form->field($model, 'input_type')->dropDownList(['number' => 'Числовой', 'text' => 'Строка', 'select' => 'Вариантлар']) ?>

    <?= $form->field($model, 'input_value')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'add1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ord')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
