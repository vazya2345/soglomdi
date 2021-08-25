<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegistrationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'client_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'analiz_id') ?>

    <?= $form->field($model, 'sum_amount') ?>

    <?php // echo $form->field($model, 'sum_cash') ?>

    <?php // echo $form->field($model, 'sum_plastik') ?>

    <?php // echo $form->field($model, 'sum_debt') ?>

    <?php // echo $form->field($model, 'add1') ?>

    <?php // echo $form->field($model, 'add2') ?>

    <?php // echo $form->field($model, 'other') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'change_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
