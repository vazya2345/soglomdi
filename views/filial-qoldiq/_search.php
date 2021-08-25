<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FilialQoldiqSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filial-qoldiq-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'filial_id') ?>

    <?= $form->field($model, 'kassir_id') ?>

    <?= $form->field($model, 'qoldiq') ?>

    <?= $form->field($model, 'last_change_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
