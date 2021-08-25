<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VidAnaliz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vid-analiz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'analiz_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sec_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'ord')->textInput() ?>

    <?= $form->field($model, 'add1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ed_izm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kolkach')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
