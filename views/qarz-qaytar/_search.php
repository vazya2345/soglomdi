<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QarzQaytarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qarz-qaytar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reg_id') ?>

    <?= $form->field($model, 'summa_plasitk') ?>

    <?= $form->field($model, 'summa_naqd') ?>

    <?= $form->field($model, 'qaytargan_vaqt') ?>

    <?php // echo $form->field($model, 'kassir_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
