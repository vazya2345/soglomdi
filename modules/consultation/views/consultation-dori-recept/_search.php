<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\consultation\models\ConsultationDoriReceptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-dori-recept-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'reg_id') ?>

    <?= $form->field($model, 'dori_title') ?>

    <?= $form->field($model, 'dori_doza') ?>

    <?= $form->field($model, 'dori_shakli') ?>

    <?php // echo $form->field($model, 'dori_mahali') ?>

    <?php // echo $form->field($model, 'dori_davomiyligi') ?>

    <?php // echo $form->field($model, 'dori_qabul') ?>

    <?php // echo $form->field($model, 'dori_qayvaqtda') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'create_userid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
