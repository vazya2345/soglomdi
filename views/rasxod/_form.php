<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Filials;
use app\models\Users;
use app\models\SRasxodTypes;
use app\models\Referals;

/* @var $this yii\web\View */
/* @var $model app\models\Rasxod */
/* @var $form yii\widgets\ActiveForm */

$y = date('Y');
$m = date('m');
$per_arr = [];
for ($i=1; $i <= 12; $i++) {
    if($i<10){
        $n = $y . '-0'.$i. '-' .  '01';
        $per_arr[$n] = $n;
        if($m==$i){
            $now = $n;
        }
    }
    else{
        $n = $y . '-'.$i. '-' .  '01';
        $per_arr[$n] = $n;
        if($m==$i){
            $now = $n;
        }
    }
}
$model->rasxod_period = $now;
?>

<div class="rasxod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'filial_id')->dropDownList(Filials::getAll()) ?>

    <?= $form->field($model, 'summa')->textInput(['type'=>'number', 'max' => $mybalance]) ?>

    <?= $form->field($model, 'sum_type')->dropDownList(['1'=>'Нақд','2'=>'Пластик']) ?>

    <?= $form->field($model, 'rasxod_type')->dropDownList(SRasxodTypes::getAll()) ?>

    <?= $form->field($model, 'rasxod_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rasxod_period')->dropDownList($per_arr,['prompt'=>'Период танланг...']) ?>

    <?= $form->field($model, 'status')->dropDownList(['1'=>'Юборилди']) ?>

    <?= $form->field($model, 'send_user')->dropDownList(Users::getAll(),['prompt'=>'Агар ходим оркали юбораётган бўлсангиз, ходимни танланг...']) ?>

    <?= $form->field($model, 'referal_id')->dropDownList(Referals::getAll(),['prompt'=>'Агар агенга юбораётган бўлсангиз, агентни танланг...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
