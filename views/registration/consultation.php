<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SAnaliz;
use app\models\Referals;
use app\models\Registration;
use app\models\Reagent;
use app\models\Client;
use app\models\Users;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = 'Консультация';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->ref_code = 131;
$tumans = [
'Андижон шахри'=>'Андижон шахри',
'Хонобод шахри'=>'Хонобод шахри',
'Олтинкўл тумани'=>'Олтинкўл тумани',
'Андижон тумани'=>'Андижон тумани',
'Асака тумани'=>'Асака тумани',
'Балиқчи тумани'=>'Балиқчи тумани',
'Бўстон тумани'=>'Бўстон тумани',
'Булоқбоши тумани'=>'Булоқбоши тумани',
'Жалақудуқ тумани'=>'Жалақудуқ тумани',
'Избоскан тумани'=>'Избоскан тумани',
'Қўрғонтепа тумани'=>'Қўрғонтепа тумани',
'Мархамат тумани'=>'Мархамат тумани',
'Пахтаобод тумани'=>'Пахтаобод тумани',
'Улуғнор тумани'=>'Улуғнор тумани',
'Хўжаобод тумани'=>'Хўжаобод тумани',
'Шахрихон тумани'=>'Шахрихон тумани',
'Бошка вилоят'=>'Бошка вилоят',
];

$doctors = Users::getConsultationDoctors();

$analizs = SAnaliz::find()->where(['is_active'=>1])->all();
?>
<?php $form = ActiveForm::begin(); ?>
<div class="card">
	<div class="card-header bg-primary">
		Мижоз хакидаги маълумотлар:
	</div>
	<div class="card-body">
		<div class="row" style="margin-bottom: 10px;">
			<div class="col-3">
				<label class="control-label" for="myclientsearch">Мижоз фамилиясини киритинг</label>
			</div>
			<div class="col-9">
				<?= Select2::widget([
					'theme' => Select2::THEME_KRAJEE_BS4,
				    'name' => 'clientsearch',
				    'data' => Client::getAll(),
				    'maintainOrder' => true,
				    'options' => [
				    	'placeholder' => 'Мижознинг фамилиясини киритинг...',
				    	'onchange'=>'getClientById(this)',
				        'id'=>'myclientsearch',

				    ],
				    'pluginOptions' => [
				        'allowClear' => true,
				        'checked'=>$model->ref_code,
				    ],
				]);?>
			</div>
		</div>
		<div class="row">
			<div class="col-3">
				<?= $form->field($model_client, 'doc_seria')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-3">
			    <?= $form->field($model_client, 'doc_number')->textInput(['maxlength' => true, 'onblur'=>'checkClient()']) ?>
			</div>
		

			<div class="col-3">
			    <?= $form->field($model_client, 'fname')->textInput(['maxlength' => true,'required'=>true]) ?>
			</div>
			<div class="col-3">
			    <?= $form->field($model_client, 'lname')->textInput(['maxlength' => true,'required'=>true]) ?>
			</div>
			<div class="col-3">
			    <?= $form->field($model_client, 'mname')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-3">
			    <?= $form->field($model_client, 'birthdate')->textInput(['type'=>'date','required'=>true]) ?>
			</div>
			<div class="col-3">
			    <?= $form->field($model_client, 'sex')->dropDownList(['M' =>'Эркак', 'F' =>'Аёл']) ?>
			</div>
			<div class="col-3">
			    
				<div class="row" style="margin-bottom: 10px;">
					<div class="col-12">
						<label class="control-label" for="myRefsearch">Реферал</label>
					</div>
					<div class="col-12">
						<?= Select2::widget([
							'theme' => Select2::THEME_KRAJEE_BS4,
						    'name' => 'Registration[ref_code]',
						    'data' => Referals::getAll(),
						    'value' => 3,
						    'options' => [
						    	'placeholder' => 'Рефералнинг фамилиясини киритинг...',
						        'id'=>'myRefsearch',
						        'class'=>'form-control',
						    ],
						    'pluginOptions' => [
						        'allowClear' => true,
						    ],
						])?>
					</div>
				</div>
			</div>

			<div class="col-3">
			    <?= $form->field($model_client, 'add1')->textInput(['type'=>'tel', 'maxlength' => 13, 'value' => '+998', 'title' => 'Телефон рақамини +998999999999 форматида киритинг', 'class' => 'form-control', 'required'=>'required', 'oninput'=>'telcheck()']) ?>
			</div>
			<div class="col-3">
			    <?= $form->field($model_client, 'address_tuman')->dropDownList(['' => 'Танланг...']+$tumans) ?>
			</div>

			<div class="col-3">
			    <?= $form->field($model_client, 'address_text')->textInput(['maxlength' => true]) ?>
			</div>

			<div class="col-3">
				
			    <?= $form->field($model, 'lab_vaqt')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label('') ?>
			    <?= $form->field($model, 'tashxis')->hiddenInput(['value' => 'Кўрик'])->label('') ?>
			    <?= $form->field($model, 'other')->hiddenInput(['value' => 'Кўрик'.date('s')])->label('') ?>
			</div>


		</div>

	</div>
</div>






<div class="registration-create card">
	<div class="card-body analizs-cont">


<div class="row">
	<div class="col-6">
	<div class="card card-success">
      <div class="card-header border-0">
        	<h4 class="card-title w-100">
                <a class="d-block w-100">
                  Консультация
                </a>
          	</h4>
      </div>
      <div class="card-body">
<?php
	$analizs = SAnaliz::find()->where(['group_id'=>36,'is_active'=>1])->orderBy(['ord'=>SORT_ASC])->all(); 
	foreach ($analizs as $analiz) {
		echo '
				<div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" onclick="setPricePlus(this)" id="customCheckbox'.$analiz->id.'" alt="'.$analiz->id.'" name=analiz["'.$analiz->id.'"]>
                  <label for="customCheckbox'.$analiz->id.'" class="custom-control-label">'.$analiz->title.'</label>
                </div>
		';
	}
			
		
?>
		</div>
	</div>
	</div>
	<div class="col-6">
	<div class="card card-success">
      <div class="card-header border-0">
        	<h4 class="card-title w-100">
                <a class="d-block w-100">
                  Консультация врачи
                </a>
          	</h4>
      </div>
      <div class="card-body">
		
			<?= $form->field($model_consultation_doctor, 'consultation_doctor_id')->dropDownList(['' => 'Танланг...']+$doctors, ['required'=>true]) ?>

		</div>
	</div>
	</div>
</div>






		
		<div class="row">
			<div class="col-lg-12">
				<?= $form->field($model, 'sum_amount')->textInput(['readonly'=>true,'value'=>0]) ?>
				<?= $form->field($model, 'skidka_reg')->textInput(['maxlength' => true,'type'=>'number','oninput'=>'setSkidkaSum(this)']) ?>

			    <div class="form-group">
			        <?= Html::submitButton('Саклаш', ['id'=>'savebutton_1','class' => 'btn btn-success', 'disabled'=>true,
			        'data' => [
		                'confirm' => 'Ишончингиз комилми?',
		                'method' => 'post',
		            ],]) ?>
		            <span id='telerror'>Тел рақамини тўғри киритинг</span>
			    </div>
			</div>
		</div>    
	</div>
	</div>
<div id="newanalizdiv_1"></div>

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
				checkReagents(elem.alt);
			}
			else{
				sum = sum-arr[elem.alt];
				getReagentsMinus(elem.alt);
				checkReagentsMinus(elem.alt);
			}
		}
		else{
			sum = sum+arr[elem.alt];
			getIndicators(elem.alt,$("#client-sex").val(),$("#client-birthdate").val());
			getReagentsPlus(elem.alt);
			checkReagents(elem.alt);
		}
		
		$("#registration-sum_amount").val(sum);
	}
	function setSkidkaSum(elem){
		var sum_skidka = 0;
		var sum_amount = 0;
		sum_amount = $("#registration-sum_amount").val();
		sum_skidka = $("#registration-skidka_reg").val();
		if(sum_skidka>(sum_amount*0.2)){
			sum_skidka = sum_amount*0.2;
			alert('Скидка суммаси умумий сумманинг 20%дан ошмаслиги керак!');
			$("#registration-skidka_reg").val(sum_skidka);
		}
	}

	function checkClient(){
		var v_serie = $("#client-doc_seria").val();
		var v_number = $("#client-doc_number").val();
		if(v_serie.length>0&&v_number.length>0){
			$.ajax({
				url: '?r=client/checkdoc',         /* Куда пойдет запрос */
				method: 'get',             /* Метод передачи (post или get) */
				dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
				data: {seria: v_serie, number: v_number},     /* Параметры передаваемые в запросе. */
				success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
					$("#client-fname").val(data.fname);
					$("#client-lname").val(data.lname);
					$("#client-mname").val(data.mname); 
					$("#client-birthdate").val(data.birthdate);
					$("#client-sex").val(data.sex);
					$("#client-add1").val(data.add1);
					$("#client-address_tuman").val(data.address_tuman);
					$("#client-address_text").val(data.address_text);
					telcheck();
				}
			});
		}

	}

	function getClientById(elem){
		if(elem.value>0){
			$.ajax({
				url: '?r=client/getclientbyid',         /* Куда пойдет запрос */
				method: 'get',             /* Метод передачи (post или get) */
				dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
				data: {id: elem.value},     /* Параметры передаваемые в запросе. */
				success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
					$("#client-fname").val(data.fname);
					$("#client-lname").val(data.lname);
					$("#client-mname").val(data.mname); 
					$("#client-birthdate").val(data.birthdate);
					$("#client-sex").val(data.sex);
					$("#client-doc_seria").val(data.doc_seria);
					$("#client-doc_number").val(data.doc_number);
					$("#client-add1").val(data.add1);

					$("#client-address_tuman").val(data.address_tuman);
					$("#client-address_text").val(data.address_text);

					telcheck();
				}
			});
		}
	}

	function checkReagents(id){

			$.ajax({
				url: '?r=reagent/checkreagents',         /* Куда пойдет запрос */
				method: 'get',             /* Метод передачи (post или get) */
				dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
				data: {analiz_id: id},     /* Параметры передаваемые в запросе. */
				success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
					$('#reagent_info').append(data.info);
					if(data.status==0){
						$('#savebutton_1').attr('disabled','disabled');
					}
				}
			});

	}

	function checkReagentsMinus(id){

			$.ajax({
				url: '?r=reagent/checkreagents',         /* Куда пойдет запрос */
				method: 'get',             /* Метод передачи (post или get) */
				dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
				data: {analiz_id: id},     /* Параметры передаваемые в запросе. */
				success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
					if(data.status==0){
						$('#reagent_info').empty();
						$('#savebutton_1').removeAttr('disabled');
					}
				}
			});

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
    function telcheck(){
    	var a = $('#client-add1').val();
    	let res = a.match(/^(\+998)?\d{9}$/);
    	if(res!==null){
    		$('#telerror').html('');
    		$('#savebutton_1').prop('disabled', false);
    	}
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
	.analizs-cont{
		
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


