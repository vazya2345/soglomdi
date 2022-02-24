<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SAnaliz;
use yii\widgets\ActiveForm;
use app\models\FinishPayments;
use app\models\RegAnalizs;
use app\models\Registration;
use app\models\QarzQaytar;
use app\models\Payments;

$fmodel = FinishPayments::findOne($model->id);

$this->title = 'Тулов - ' . Client::getName($model->client_id);
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['indexkassa']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Тулов';

$tsum = Registration::getSumForPay($model->id);
?>

<?php 
if($fmodel){
?>
<div class="card">
	<div class="card-body">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'other',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            // 'user_id',
            // 'analiz_id'=>[
            //     'attribute'=>'analiz_id',
            //     'value' => function ($data) {
            //             return SAnaliz::getName($data->analiz_id);                    
            //     }
            // ],
            'sum_amount',
            'sum_cash',
            'sum_plastik',
            'sum_debt',
            'skidka_reg',
            // 'skidka_kassa',
            'create_date',

            [
                // 'attribute'=>'other',
                'label'=>'Тўланиши керак',
                'value' => function ($data) {
                        return $tsum;                    
                }
            ],
        ],
    ]) ?>
	</div>
</div>
<?php
}
else{
?>
<div class="card">
	<div class="card-body">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            // 'user_id',
            // 'analiz_id'=>[
            //     'attribute'=>'analiz_id',
            //     'value' => function ($data) {
            //             return SAnaliz::getName($data->analiz_id);                    
            //     }
            // ],
            'sum_amount',
            'skidka_reg',
            // 'skidka_kassa',
            'create_date',
            [
                'label' => 'Тўланиши керак',
                'format' => 'raw',
                'value' => function ($data) {
                        return '<b>'.Registration::getSumForPay($data->id).'</b>';                    
                }
            ],
        ],
    ]) ?>
    <br>


<?php
$payment_model = Payments::find()->where(['main_id'=>$model->id])->one();
// if($model->sum_debt==0){
if(!$payment_model){
?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sum_cash')->textInput(['type'=>'number', 'oninput'=>'checkPay('.$tsum.')','id'=>'cashsum']) ?>

    <?= $form->field($model, 'sum_plastik')->textInput(['type'=>'number', 'oninput'=>'checkPay('.$tsum.')','id'=>'plastiksum']) ?>

    <?= $form->field($model, 'sum_debt')->textInput(['type'=>'number', 'oninput'=>'checkPay('.$tsum.')','id'=>'debtsum', 'value'=>0]) ?>


    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success', 'id'=>'tulovbutton', 'disabled'=>true]) ?>
    </div>

    <?php ActiveForm::end(); ?>
 <?php
}
 ?>
	</div>
</div>
<?php
}
//// QARZ QAYTARISH
if($payment_model){
    $qmodel = QarzQaytar::getMyModelByRegId($model->id);
?>
<div class="card card-primary">
    <div class="card-header">Қарз қайтариш</div>
    <div class="card-body">
    <?php $form = ActiveForm::begin(['action'=>'?r=qarz-qaytar/save&id='.$qmodel->id]); ?>

    <?= $form->field($qmodel, 'summa_naqd')->textInput(['type'=>'number', 'oninput'=>'checkQarz('.$tsum.')','id'=>'cashqarz']) ?>

    <?= $form->field($qmodel, 'summa_plasitk')->textInput(['type'=>'number', 'oninput'=>'checkQarz('.$tsum.')','id'=>'plastikqarz']) ?>

    <div class="form-group">
        <?= Html::submitButton('Қарзни ёпиш', ['class' => 'btn btn-success', 'id'=>'qarzbutton', 'disabled'=>true]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
}
?>



<div class="card">
    <div class="card-body">
        <table id="w2" class="table table-striped table-bordered detail-view">
            <tbody>
                <tr>
                    <th>Тахлил номи</th>
                    <th>Нархи</th>
                </tr>
<?php
$analizs = RegAnalizs::find()->where(['reg_id'=>$model->id])->all();
foreach ($analizs as $analiz) {
    echo '<tr><td>'.SAnaliz::getName($analiz->analiz_id).'</td><td>'.$analiz->summa.'</td></tr>';
}
?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
	function checkPay(tsum){
		
		var cash = Number($('#cashsum').val());
		var plastik = Number($('#plastiksum').val());
		var debt = Number($('#debtsum').val());
		var all;
		all = cash+plastik+debt;
		if(all==tsum&&(cash>=0&&plastik>=0&&debt>=0)){
			$('#tulovbutton').prop('disabled', false);
		}
		else{
			$('#tulovbutton').prop('disabled', true);
		}
	}

	function checkQarz(tsum){
		
		var cash = Number($('#cashqarz').val());
		var plastik = Number($('#plastikqarz').val());
		var all;
		all = cash+plastik;
		if(all==tsum&&(cash>=0&&plastik>=0)){
			$('#qarzbutton').prop('disabled', false);
		}
		else{
			$('#qarzbutton').prop('disabled', true);
		}
	}
</script>