<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Reagent;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $model app\models\ReagentSend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reagent-send-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reagent_id')->dropDownList(Reagent::getAll(), ['prompt'=>'Танланг...']) ?>

    <?= $form->field($model, 'filial_id')->dropDownList(Filials::getAll(), ['prompt'=>'Танланг...']) ?>

    <?= $form->field($model, 'soni')->textInput() ?>


    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Юбориш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
