<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SGroups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sgroups-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->dropDownList([1=>'Актив',0=>'Неактив']) ?>

    <?= $form->field($model, 'add1')->dropDownList([1=>'Очиқ',0=>'Ёпиқ']) ?>

	<?= $form->field($model, 'ord')->textInput(['maxlength' => true]) ?>    

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
