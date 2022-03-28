<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OylikShaklSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oylik-shakl-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'period') ?>

    <?= $form->field($model, 'oylik_hodimlar_id') ?>

    <?= $form->field($model, 'fio') ?>

    <?= $form->field($model, 'fil_name') ?>

    <?php // echo $form->field($model, 'lavozim') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'summa') ?>

    <?php // echo $form->field($model, 'shakl_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
