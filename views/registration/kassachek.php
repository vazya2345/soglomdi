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
use app\models\Filials;

$fmodel = FinishPayments::findOne($model->id);

$fmodel = true;

?>
<div class="header">
    <table class="tb-header">
        <tr>
            <td align="center">
                <p class="main_title">
                    <?php
                        $fil_model = Filials::findOne(Users::getFilial($model->user_id));
                        if($fil_model&&$fil_model->chek_nomi!==false){
                            echo $fil_model->chek_nomi;
                        }
                        else{
                            echo "SOG’LOM TABASSUM";
                        }
                    ?>
                </p>
            </td>
        </tr>
        <tr>
            <td align="center">
                Тел: <?=Users::getFilPhoneNum($model->user_id)?>.
            </td>
        </tr>
    </table>
</div>

<div class="container">

<?php 
if($fmodel){
?>
<div class="card" id="client_info">
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
                'label'=>'Телефон',
                'value' => function ($data) {
                        return Client::getPhonenum($data->client_id);                    
                }
            ],
            [
                'attribute' => 'client_id',
                'label'=>'Туғилган сана',
                'value' => function ($data) {
                        return Client::getBirthDate($data->client_id);                    
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
<br>
<div class="card" id="analizs_clock">
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
<div class="card" id="payments">
    <div class="card-body">
        <table id="w1" class="table table-striped table-bordered detail-view">
            <tbody>
                <tr><th>Умумий нарх</th><td><?=number_format($model->sum_amount, 0, '.', ' ')?></td></tr>
                <?php
                    if(($model->skidka_reg+$model->skidka_kassa)>0){
                        ?>
                            <tr><th>Скидка</th><td><?=number_format($model->skidka_reg+$model->skidka_kassa, 0, '.', ' ')?></td></tr>
                        <?php
                    }
                ?>

                <?php
                    if(($model->sum_cash)>0){
                        ?>
                            <tr><th>Накд пул</th><td><?=number_format($model->sum_cash, 0, '.', ' ')?></td></tr>
                        <?php
                    }
                ?>

                <?php
                    if(($model->sum_plastik)>0){
                        ?>
                            <tr><th>Пластик</th><td><?=number_format($model->sum_plastik, 0, '.', ' ')?></td></tr>
                        <?php
                    }
                ?>

                <?php
                    if((Registration::getSumForPay($model->id))>0){
                        ?>
                            <tr><th>Қарз суммаси</th><td><?=number_format(Registration::getSumForPay($model->id), 0, '.', ' ')?></td></tr>
                        <?php
                    }
                ?>
                
                
                
                
            </tbody>
        </table>
    </div>
</div>
<?php
}
?>

</div>










<hr>
<div class="footer">
    <?php
                        if($fil_model&&$fil_model->chek_lozung!==false){
                            echo $fil_model->chek_lozung;
                        }
                        else{
                            echo "Doim sog‘ bo‘ling!";
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
    #client_info .table tr th{
        text-align: left;
        width: 50%;
        vertical-align: baseline;
        padding: 10px 0px;
    }

    #analizs_clock .table tr th{
        text-align: left;
        vertical-align: baseline;
        padding: 3px 0px;
        width: 80%;
    }
    #analizs_clock .table tr th:nth-child(2), #analizs_clock .table tr td:nth-child(2){
        text-align: right;
    }


    #payments .table tr th{
        text-align: left;
        vertical-align: baseline;
        padding: 3px 0px;
        width: 80%;
    }
    #payments .table tr th:nth-child(2), #payments .table tr td:nth-child(2){
        text-align: right;
    }

    
    .table{
        width: 100%;
    }
    #payments td{
        text-align: right;
    }
    .main_title{
        margin: 10px 0;
    }
    .header{
        margin-bottom: 10px;
    }
    .footer{
        font-style: italic;
        margin: 20px;
        text-align: center;
    }
</style>