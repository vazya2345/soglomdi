<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RasxodSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rasxod-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'filial_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'summa') ?>

    <?= $form->field($model, 'sum_type') ?>

    <?php // echo $form->field($model, 'rasxod_type') ?>

    <?php // echo $form->field($model, 'rasxod_desc') ?>

    <?php // echo $form->field($model, 'rasxod_period') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'send_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
