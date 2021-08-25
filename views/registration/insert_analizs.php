<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\RegAnalizs;
use app\models\SAnaliz;
use app\models\Client;
use app\models\Reagent;
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = 'Тахлилларни ўзгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$reg_analizs = RegAnalizs::getAnalizIdsByRegId($model->id);

?>
<?php $form = ActiveForm::begin(); ?>
<div class="registration-create card">
    <div class="card-body analizs-cont">
        <div class="row">
<?php
    $i = 0;
    $arr = [0,10,15,20];
    $arr1 = [9,14,19,24];
    foreach ($groups as $group) {
        if(in_array($i, $arr)){
            echo '<div class="col-lg-3">';
        }
        echo   '
                    
                            <div class="card card-success" id="accordion'.$group->id.'">
                              <div class="card-header border-0">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100" data-toggle="collapse" href="#collapse'.$group->id.'" aria-expanded="true">
                                      '.$group->title.'
                                    </a>
                                </h4>
                              </div>';
                              if($group->add1==1){
                                echo '<div id="collapse'.$group->id.'" class="collapse show" data-parent="#accordion'.$group->id.'">';
                              }
                              else{
                                echo '<div id="collapse'.$group->id.'" class="collapse" data-parent="#accordion'.$group->id.'">';
                              }


                              echo '
                                  <div class="card-body">
                                    <div>';
                                        $analizs = SAnaliz::find()->where(['group_id'=>$group->id,'is_active'=>1])->all();
                                    foreach ($analizs as $analiz) {
                                        if(in_array($analiz->id, $reg_analizs)){
                                            echo '
                                                <div class="custom-control custom-checkbox">
                                                  <input class="custom-control-input" type="checkbox" onclick="setPricePlus(this)" id="customCheckbox'.$analiz->id.'" alt="'.$analiz->id.'" name=analiz["'.$analiz->id.'"] checked>
                                                  <label for="customCheckbox'.$analiz->id.'" class="custom-control-label">'.$analiz->title.'</label>
                                                </div>
                                            ';
                                        }
                                        else{
                                            echo '
                                                <div class="custom-control custom-checkbox">
                                                  <input class="custom-control-input" type="checkbox" onclick="setPricePlus(this)" id="customCheckbox'.$analiz->id.'" alt="'.$analiz->id.'" name=analiz["'.$analiz->id.'"]>
                                                  <label for="customCheckbox'.$analiz->id.'" class="custom-control-label">'.$analiz->title.'</label>
                                                </div>
                                            ';

                                        }
                                        
                                    }
            echo '                  </div>
                                  </div>
                              </div>
                            </div>
                    
                ';
        if(in_array($i, $arr1)){
            if($i==24){
                echo Reagent::getForUpdateText($model->id);
            }
            echo '</div>';
        }
        $i++;
    }
?>

        </div>






        <div class="row">
            <div class="col-lg-12">
                    <div id="indikators" class="row">
                        
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'sum_amount')->textInput(['readonly'=>true,'value'=>$model->sum_amount]) ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Саклаш', ['id'=>'savebutton_1','class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Ишончингиз комилми?',
                        'method' => 'post',
                    ],]) ?>
                </div>
            </div>
        </div>    
    </div>
</div>

                  
    
<?php ActiveForm::end(); ?>

<script type="text/javascript">
    function setPricePlus(elem){
        let arr = [];
        var sum = 0;
        <?php
        $prmodels = SAnaliz::getAllPrice();
        foreach ($prmodels as $key) {
            echo "arr[".$key->id."]=".$key->price.";";
        }
        ?>
        sum = $("#registration-sum_amount").val();
        if(sum.length>0){
            sum = parseInt(sum);
            if(elem.checked){
                sum = sum+arr[elem.alt];
                getIndicators(elem.alt,$("#client-sex").val(),$("#client-birthdate").val());
                getReagentsPlus(elem.alt);
            }
            else{
                sum = sum-arr[elem.alt];
                getReagentsMinus(elem.alt);
            }
        }
        else{
            sum = sum+arr[elem.alt];
            getIndicators(elem.alt,$("#client-sex").val(),$("#client-birthdate").val());
            getReagentsPlus(elem.alt);
        }
        $("#registration-sum_amount").val(sum);
    }


    function getIndicators(id,sex,birthdate){
        $.ajax({
            url: '?r=pokaz-limits/getindikators',         /* Куда пойдет запрос */
            method: 'get',             /* Метод передачи (post или get) */
            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
            data: {analiz_id: id,sex: sex, birthdate: birthdate, myid: 0},     /* Параметры передаваемые в запросе. */
            success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
                $('#indikators').append(data);
            }
        });
        
    }

    function getReagentsPlus(id){
        $.ajax({
            url: '?r=reagent-rel/getreagents',         /* Куда пойдет запрос */
            method: 'get',             /* Метод передачи (post или get) */
            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
            data: {analiz_id: id},     /* Параметры передаваемые в запросе. */
            success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
                var obj1;
                var arr = $.parseJSON(data);
                
                for (let i = 0; i < arr.length; i++) {
                    obj1 = document.getElementById('myreaginp'+arr[i]);
                    if(obj1.value<1){
                        obj1.value++;
                    }       
                }
            }
        });
    }

    function getReagentsMinus(id){
        $.ajax({
            url: '?r=reagent-rel/getreagents',         /* Куда пойдет запрос */
            method: 'get',             /* Метод передачи (post или get) */
            dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
            data: {analiz_id: id},     /* Параметры передаваемые в запросе. */
            success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
                var obj1;
                var arr = $.parseJSON(data);
                
                for (let i = 0; i < arr.length; i++) {
                    obj1 = document.getElementById('myreaginp'+arr[i]);
                    if(obj1.value>0){
                        obj1.value--;
                    }       
                }
            }
        });
    }
    function myfuncminus(id){   
        var obj1 = document.getElementById('myreaginp'+id);
        obj1.value--;
    }
    function myfuncplus(id){
        var obj1 = document.getElementById('myreaginp'+id);
        obj1.value++;
    }
</script>

<div id="reagents"></div>
<style type="text/css">
    .pokaz-block{
        display: block;
    }
    .btn{
        margin-left: 10px;
    }
    .group_title{
        text-align: center;
        background-color: #28a745;
        color: white;
        padding: 5px;
    }
    .group_content{
        border: 1px solid black;
        max-width: 20%;
    }
    .in_inline div{
        display: inline;
    }
    .reagent_birmarta td{
        border-bottom: 1px solid silver ;
    }
    .reagent_title{
        width: 150px;
    }
    .reagent_soni{
        padding: 10px;
    }
    .reagent_birmarta td a{
        cursor: pointer;
    }
    .input-group-prepend, .input-group-append{
        cursor: pointer;    
    }
    .mb-3{
        margin: 5px!important;
    }
    .mb-3 input{
        text-align: center;
    }
</style>


