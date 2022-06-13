<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\dori\models\DoriShakli;
use app\modules\dori\models\DoriQabul;
/* @var $this yii\web\View */
/* @var $model app\modules\dori\models\DoriList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dori-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doza')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shakli')->dropDownList(DoriShakli::getAll()) ?>

    <?= $form->field($model, 'qabul')->dropDownList(DoriQabul::getAll()) ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
