<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FqSendsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fq-sends-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fq_id') ?>

    <?= $form->field($model, 'sum') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'send_date') ?>

    <?php // echo $form->field($model, 'rec_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
