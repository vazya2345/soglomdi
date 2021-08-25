<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ResultSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="result-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'main_id') ?>

    <?= $form->field($model, 'analiz_id') ?>

    <?= $form->field($model, 'pokaz_id') ?>

    <?= $form->field($model, 'reslut_value') ?>

    <?php // echo $form->field($model, 'result_answer') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
