<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PokazLimitsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pokaz-limits-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pokaz_id') ?>

    <?= $form->field($model, 'indikator') ?>

    <?= $form->field($model, 'indikator_value') ?>

    <?= $form->field($model, 'norma') ?>

    <?php // echo $form->field($model, 'down_limit') ?>

    <?php // echo $form->field($model, 'up_limit') ?>

    <?php // echo $form->field($model, 'add1') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
