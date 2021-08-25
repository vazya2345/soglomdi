<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\InpTypes;

/* @var $this yii\web\View */
/* @var $model app\models\SPokazatel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spokazatel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php 
        if(isset($analiz_id)){
            echo $form->field($model, 'analiz_id')->textInput(['value'=>$analiz_id]);
        }
        else{
            echo $form->field($model, 'analiz_id')->textInput();
        }
    ?>

    <?= $form->field($model, 'add1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ord')->textInput() ?>

    <?= $form->field($model, 'inptype_id')->dropDownList([''=>'Танланг...']+InpTypes::getAll()) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
