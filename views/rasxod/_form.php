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
<?php
    if($mybalance<10000){

    

    echo $form->field($model, 'summa')->textInput(['type'=>'text', 'disabled'=>true, 'value'=>'Балансингизда юбориш учун маблағ етарли эмас.']);

    }
    else{
        if(Users::getMyFil()==1){
            echo $form->field($model, 'filial_id')->dropDownList(Filials::getAll());
        }
        else{
            echo $form->field($model, 'filial_id')->hiddenInput(['value'=>Users::getMyFil()])->label(false);
        }
        
        echo $form->field($model, 'summa')->textInput(['type'=>'number', 'min' => 10000, 'max' => $mybalance]);
        echo $form->field($model, 'sum_type')->dropDownList(['1'=>'Нақд','2'=>'Пластик']);
        echo $form->field($model, 'rasxod_type')->dropDownList(SRasxodTypes::getAll());
        echo $form->field($model, 'rasxod_desc')->textarea(['rows' => 6]);
        echo $form->field($model, 'rasxod_period')->dropDownList($per_arr,['prompt'=>'Период танланг...']);
        echo $form->field($model, 'status')->hiddenInput(['value'=>'1'])->label(false);
        echo $form->field($model, 'send_user')->dropDownList(Users::getAll(),['prompt'=>'Агар ходим оркали юбораётган бўлсангиз, ходимни танланг...']);
        echo $form->field($model, 'referal_id')->dropDownList(Referals::getAll(),['prompt'=>'Агар агенга юбораётган бўлсангиз, агентни танланг...']);
        echo '<div class="form-group">';
        echo Html::submitButton('Саклаш', ['class' => 'btn btn-success']);
        echo '</div>';
    }
?>

    <?php ActiveForm::end(); ?>

</div>
