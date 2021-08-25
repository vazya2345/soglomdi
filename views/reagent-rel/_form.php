<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Reagent;
use app\models\SAnaliz;
/* @var $this yii\web\View */
/* @var $model app\models\ReagentRel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reagent-rel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reagent_id')->dropDownList(Reagent::getAll()) ?>

    <?= $form->field($model, 'analiz_id')->dropDownList(SAnaliz::getAll()) ?>

    <?= $form->field($model, 'soni')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
