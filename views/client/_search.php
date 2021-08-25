<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fname') ?>

    <?= $form->field($model, 'lname') ?>

    <?= $form->field($model, 'mname') ?>

    <?= $form->field($model, 'birthdate') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'doc_seria') ?>

    <?php // echo $form->field($model, 'doc_number') ?>

    <?php // echo $form->field($model, 'inn') ?>

    <?php // echo $form->field($model, 'add1') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'change_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
