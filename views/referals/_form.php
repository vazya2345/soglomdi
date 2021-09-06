<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $model app\models\Referals */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referals-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refnum')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'value' => $model->phone=='' ? '+998' : $model->phone]) ?>

    <?= $form->field($model, 'user_id')->textInput(['type'=>'hidden','value'=>Yii::$app->user->id]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'add1')->textInput(['maxlength' => true, 'oninput'=>'clearfunc(1)']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'fix_sum')->textInput(['maxlength' => true, 'oninput'=>'clearfunc(2)']) ?>
        </div>
    </div>

    <?= $form->field($model, 'avans_sum')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'plastik_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'plastik_date')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'plastik_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'filial')->dropDownList(Filials::getAll()) ?>
    

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    .field-referals-user_id label {
        display: none;
    }
</style>

<script type="text/javascript">
    function clearfunc(a){
        if(a==1){
            $("#referals-fix_sum").val('');
        }
        else{
            $("#referals-add1").val('');
        }
    }
</script>