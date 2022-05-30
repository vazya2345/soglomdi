<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Filials;
use app\models\Users;
use app\models\SRasxodTypes;
use app\models\Referals;
use app\models\OylikHodimlar;
use app\models\OylikPeriods;



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
        echo '<div class="row">';

        if(Users::getMyFil()==1){
            echo '<div class="col-6">'.$form->field($model, 'filial_id')->dropDownList(Filials::getAll()).'</div>';
        }
        else{
            echo '<div class="col-6">'.$form->field($model, 'filial_id')->hiddenInput(['value'=>Users::getMyFil()])->label(false).'</div>';
        }
        
        echo '<div class="col-6">'.$form->field($model, 'summa')->textInput(['type'=>'number', 'min' => 10000, 'max' => $mybalance]).'</div>';
        echo '</div>';
?>




<div class="row">
    <div class="col-6"><?=$form->field($model, 'sum_type')->dropDownList(['1'=>'Нақд','2'=>'Пластик'])?></div>
    <div class="col-6"><?=$form->field($model, 'rasxod_type')->dropDownList(SRasxodTypes::getAll(), ['onchange'=>'getOylikCols(this)'])?></div>
</div>



<div id="oylikcols">
    <div  class="row">
        <div class="col-6"><?=$form->field($oylikuderj_model, 'oylik_hodimlar_id')->dropDownList(OylikHodimlar::getAll())?></div>
        
        <div class="col-6"><?=$form->field($oylikuderj_model, 'period')->textInput(['disabled'=>true, 'value'=>OylikPeriods::getActivePeriod()])?></div>
    </div>
</div>


<div class="row">
    
    <div class="col-6">
        <?=$form->field($model, 'rasxod_period')->dropDownList($per_arr,['prompt'=>'Период танланг...'])?>
        <?=$form->field($model, 'status')->hiddenInput(['value'=>'1'])->label(false)?>
        <?=$form->field($model, 'send_user')->dropDownList(Users::getAll(),['prompt'=>'Агар ходим оркали юбораётган бўлсангиз, ходимни танланг...'])?>
        <?=$form->field($model, 'referal_id')->dropDownList(Referals::getAll(),['prompt'=>'Агар агенга юбораётган бўлсангиз, агентни танланг...'])?>
    </div>

    <div class="col-6">
        <?=$form->field($model, 'rasxod_desc')->textarea(['rows' => 8])?>
    </div>
</div>
<?php
        
        echo '<div class="form-group">';
        echo Html::submitButton('Саклаш', ['class' => 'btn btn-success', 'data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ]]);
        echo '</div>';
    }
?>

    <?php ActiveForm::end(); ?>

</div>

<style type="text/css">
    #oylikcols{
        display: none;
    }
</style>


<script type="text/javascript">
    function getOylikCols(elem) {
        if(elem.value==5){
            $('#oylikcols').show();
        }
        else{
            $('#oylikcols').hide();   
        }
    }
</script>
