<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Filials;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\FilialQoldiq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filial-qoldiq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filial_id')->dropDownList(Filials::getAll()) ?>

    <?= $form->field($model, 'kassir_id')->dropDownList([''=>'Танланг...']+Users::getAllKassirs()) ?>

    <?= $form->field($model, 'qoldiq')->textInput() ?>

     <?= $form->field($model, 'qoldiq_type')->dropDownList([1=>'Нақд',2=>'Пластик']) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?> 
    </div>

    <?php ActiveForm::end(); ?>

</div>
