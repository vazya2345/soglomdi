<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SAnaliz;
use yii\widgets\ActiveForm;
use app\models\FinishPayments;
use app\models\RegAnalizs;
use app\models\Registration;
use app\models\Users;

$fmodel = FinishPayments::findOne($model->id);

$fmodel = true;



$this->title = 'Тулов - ' . Client::getName($model->client_id);
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['indexkassa']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Тулов';
?>
<div class="header">
    <table class="tb-header">
        <tr>
            <td>
                <img src="./img/logo_min.png" class="logo" height="60">
            </td>
            <td align="center">
                <p class="main_title">SOG’LOM TABASSUM</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                Тел: <?=Users::getFilPhoneNum($model->user_id)?>.
            </td>
        </tr>
    </table>
<br>
</div>

<div class="container">

<?php 
if($fmodel){
?>
<div class="card">
	<div class="card-body">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'other',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            [
                'attribute' => 'client_id',
                'label'=>'Тел',
                'value' => function ($data) {
                        return Client::getPhonenum($data->client_id);                    
                }
            ],
            'create_date'=>[
                'attribute' => 'create_date',
                'value' => function ($data) {
                        return date('Y-m-d', strtotime($data->create_date));                    
                }
            ],
        ],
    ]) ?>
	</div>
</div>
<?php
}
?>
<br><br>
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
    echo '<tr><td>'.SAnaliz::getName($analiz->analiz_id).'</td><td>'.number_format($analiz->summa, 0, '.', ' ').'</td></tr>';
}
?>
            </tbody>
        </table>
    </div>
</div>


<br>
<br>

<?php 
if($fmodel){
?>
<div class="card">
    <div class="card-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sum_amount'=>[
                'attribute'=>'sum_amount',
                'value' => function ($data) {
                    if($data->sum_amount>0)
                        return number_format($data->sum_amount, 0, '.', ' ');
                    else
                        return 0;
                }
            ],
            'skidka_reg'=>[
                'attribute'=>'skidka_reg',
                'label'=>'Скидка',
                'value' => function ($data) {
                    if($data->skidka_reg>0)
                        return number_format($data->skidka_reg+$data->skidka_kassa, 0, '.', ' ');
                    else
                        return 0;
                }
            ],
            'sum_cash'=>[
                'attribute'=>'sum_cash',
                'value' => function ($data) {
                    if($data->sum_cash>0)
                        return number_format($data->sum_cash, 0, '.', ' ');
                    else
                        return 0;
                }
            ],
            'sum_plastik'=>[
                'attribute'=>'sum_plastik',
                'label'=>'Пластик',
                'value' => function ($data) {
                    if($data->sum_plastik>0)
                        return number_format($data->sum_plastik, 0, '.', ' ');
                    else
                        return 0;
                }
            ],
            // 'sum_debt'=>[
            //     'attribute'=>'sum_debt',
            //     'value' => function ($data) {
            //         if($data->sum_debt>0)
            //             return number_format($data->sum_debt, 0, '.', ' ');
            //         else
            //             return 0;
            //     }
            // ],
            
            [
                'attribute'=>'other',
                'label'=>'Қарз суммаси',
                'value' => function ($data) {
                        return Registration::getSumForPay($data->id);                    
                }
            ],
        ],
    ]) ?>
    </div>
</div>
<?php
}
?>

</div>

<style type="text/css">
@media print {
    /* здесь будут стили для печати */
    body {
        font-size: 28px;
    }
}
    body {
        font-size: 28px;
    }
    .table tr th{
        text-align: left;
    }
    .table{
        width: 100%;
    }
    #w1 td{
        text-align: right;
    }
</style>