<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\consultation\models\ConsultationDoriRecept */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-dori-recept-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'reg_id')->textInput() ?>

    <?= $form->field($model, 'dori_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dori_doza')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dori_shakli')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dori_mahali')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dori_davomiyligi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dori_qabul')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dori_qayvaqtda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'create_userid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
