<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MoneySendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="money-send-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'send_user') ?>

    <?= $form->field($model, 'rec_user') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'send_date') ?>

    <?php // echo $form->field($model, 'rec_date') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'send_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
