<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $model app\models\OylikHodimlar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oylik-hodimlar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summa')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'filial_id')->dropDownList(Filials::getAll()) ?>

    <?= $form->field($model, 'lavozim')->textInput() ?>

    <?= $form->field($model, 'other_info')->dropDownList(['1' => 'Ха', '0' => 'Йўқ']) ?>


    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
