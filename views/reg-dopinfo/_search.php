<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegDopinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reg-dopinfo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reg_id') ?>

    <?= $form->field($model, 'indikator_id') ?>

    <?= $form->field($model, 'value') ?>

    <div class="form-group">
        <?= Html::submitButton('Кидириш', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Кайта урнатиш', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
