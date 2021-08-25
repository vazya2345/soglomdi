<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SAnaliz;
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="card">
	<div class="card-header bg-primary">
		Мижоз хакидаги маълумотлар:
	</div>
	<div class="card-body">

			<?= $form->field($model_client, 'doc_seria')->textInput(['maxlength' => true]) ?>

		    <?= $form->field($model_client, 'doc_number')->textInput(['maxlength' => true, 'onblur'=>'checkClient()']) ?>

		    <div id="ajaxfill">
			    <?= $form->field($model_client, 'fname')->textInput(['maxlength' => true,'required'=>true]) ?>

			    <?= $form->field($model_client, 'lname')->textInput(['maxlength' => true,'required'=>true]) ?>

			    <?= $form->field($model_client, 'mname')->textInput(['maxlength' => true]) ?>

			    <?= $form->field($model_client, 'birthdate')->textInput(['type'=>'date','required'=>true]) ?>

			    <?= $form->field($model_client, 'sex')->dropDownList(['M' =>'Эркак', 'F' =>'Аёл']) ?>

			    <?= $form->field($model, 'add1')->textInput(['maxlength' => true]) ?>
			</div>

	</div>
</div>


<div class="registration-create card">
	<div class="card-body">
		    <?= $form->field($model, 'analiz_id')->dropDownList(SAnaliz::getAll(),['onchange'=>'setPrice()','prompt'=>'Тахлилни танланг...']) ?>
		    <div id="indikators">
		    	
		    </div>

		    <?= $form->field($model, 'sum_amount')->textInput(['readonly'=>true]) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Саклаш', ['id'=>'savebutton_1','class' => 'btn btn-success']) ?>
	        <?= Html::button('Тахлил кушиш', ['id'=>'addnewtahlil_1','class' => 'btn btn-primary', 'onclick'=>'addAnaliz(1)']) ?>
	    </div>	    
	</div>
</div>
<div id="newanalizdiv_1"></div>

<?php ActiveForm::end(); ?>

<script type="text/javascript">
	function setPrice(){
		let arr = [];
		<?php
		$prmodels = SAnaliz::getAllPrice();
		foreach ($prmodels as $key) {
			echo "arr[".$key->id."]=".$key->price.";";
		}
		?>
		getIndicators($("#registration-analiz_id").val(),$("#client-sex").val(),$("#client-birthdate").val());
		$("#registration-sum_amount").val(arr[$("#registration-analiz_id").val()]);
	}

	function checkClient(){
		var v_serie = $("#client-doc_seria").val();
		var v_number = $("#client-doc_number").val();
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
				$('#indikators').html(data);
			}
		});
	}

	function addAnaliz(id){
		var mytext = '';
		var nid = id+1;
		$("#savebutton_"+id).hide();
		$("#addnewtahlil_"+id).hide();
		mytext = '<div class="card"><div class="card-body">';
		mytext += '<div class="form-group field-registration-analiz_id'+id+' required"><label class="control-label" for="registration-analiz_id'+id+'">Тахлил</label>';
		mytext += '<select id="registration-analiz_id'+id+'" class="form-control" name="regs['+id+'][analiz_id]" onchange="setPrice1('+id+')" aria-required="true">';
		mytext += '<option value="">Тахлилни танланг...</option>';
<?php
	foreach (SAnaliz::getAll() as $key => $value) {
		echo "mytext += '<option value=\"".$key."\">".$value."</option>';";
	}
?>
		mytext += '</select><div class="help-block"></div></div>';
		mytext += '<div id="indikators'+id+'"></div><div class="form-group field-registration-sum_amount">';
		mytext += '<label class="control-label" for="registration-sum_amount'+id+'">Нарх</label>';
		mytext += '<input type="text" id="registration-sum_amount'+id+'" class="form-control" name="regs['+id+'][sum_amount]" readonly="">';
		mytext += '<div class="help-block"></div></div><div class="form-group">';
		mytext += '<button type="submit" id="savebutton_'+nid+'" class="btn btn-success">Саклаш</button>';
		mytext += '<button type="button" id="addnewtahlil_'+nid+'" class="btn btn-primary" onclick="addAnaliz('+nid+')">Тахлил кушиш</button>';
		mytext += '</div>';
		
		mytext += '</div></div>';
		mytext += '<div id="newanalizdiv_'+nid+'"></div>';
		
		$("#newanalizdiv_"+id).append(mytext);
		
	}

	function setPrice1(id){
		let arr = [];
		<?php
		$prmodels = SAnaliz::getAllPrice();
		foreach ($prmodels as $key) {
			echo "arr[".$key->id."]=".$key->price.";";
		}
		?>
		getIndicators1($("#registration-analiz_id"+id).val(),$("#client-sex").val(),$("#client-birthdate").val(),id);
		$("#registration-sum_amount"+id).val(arr[$("#registration-analiz_id"+id).val()]);
	}

	function getIndicators1(id,sex,birthdate,myid){
		$.ajax({
			url: '?r=pokaz-limits/getindikators',         /* Куда пойдет запрос */
			method: 'get',             /* Метод передачи (post или get) */
			dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
			data: {analiz_id: id,sex: sex, birthdate: birthdate, myid: myid},     /* Параметры передаваемые в запросе. */
			success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
				$('#indikators'+myid).html(data);
			}
		});
	}
</script>

<style type="text/css">
	.pokaz-block{
		display: block;
	}
	.btn{
		margin-left: 10px;
	}
</style>



