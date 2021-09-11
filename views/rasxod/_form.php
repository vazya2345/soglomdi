<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rasxod */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rasxod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filial_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'summa')->textInput() ?>

    <?= $form->field($model, 'sum_type')->textInput() ?>

    <?= $form->field($model, 'rasxod_type')->textInput() ?>

    <?= $form->field($model, 'rasxod_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rasxod_period')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'send_user')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
