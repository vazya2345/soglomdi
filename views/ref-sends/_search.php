<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefSendsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sends-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'refnum') ?>

    <?= $form->field($model, 'sum') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'send_date') ?>

    <?php // echo $form->field($model, 'rec_date') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
