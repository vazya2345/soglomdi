<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VidAnalizSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vid-analiz-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'analiz_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'sec_text') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'ord') ?>

    <?php // echo $form->field($model, 'add1') ?>

    <?php // echo $form->field($model, 'ed_izm') ?>

    <?php // echo $form->field($model, 'kolkach') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
