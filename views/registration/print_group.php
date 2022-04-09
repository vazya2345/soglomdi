<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\PokazLimits;
use app\models\SAnaliz;
use app\models\Result;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;



$this->title = 'Натижа';
$this->params['breadcrumbs'][] = $this->title;
$client_name = Client::getName($model->client_id);
$res_date = Result::getMaxDate($model->id);
$name = $client_name.' '.date("Y-m-d",strtotime($res_date));
header('Content-disposition: inline; filename="' . $name . '.pdf"'); 
?>

<div class="header">
    <table class="tb-header">
        <tr>
            <td align="center">
                <img src="./img/logo_pdf.png" class="logo" width="250">
            </td>
            <td>
<?php 

$qr = Text::widget([
    'outputDir' => '@webroot/upload/qrcode',
    'outputDirWeb' => '@web/upload/qrcode',
    'ecLevel' => QRcode::QR_ECLEVEL_L,
    'text' => Url::home('http').'?r=registration%2Fviewqr&group='.$group.'&reg_id='.$_GET['reg_id'],
    'size' => 2,
]);
$qr = str_replace('/web', './', $qr);
echo $qr;
?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" class="adress">
                «SOG’LOM TABASSUM» ХК, манзил Андижон ш., Бобур шох кўчаси 109-Б уй. Тел:(0-595) 204-01-50.
            </td>

        </tr>
    </table>

</div>

<div class="container">
    


<div class="content-top-table-div">
     <table class="table_client">
        <tr>
            <td class="bold">Пациент: <?=$client_name?></td>
            <td class="bold" rowspan="2" valign="top">Дата: <?=$res_date?></td>
            <td class="bold">Дата рождения: <?=Client::getBirthDate($model->client_id)?></td>
        </tr>
    </table>
    <table class="table_analiz">
        <tr>
            <td class="name-of-analiz" colspan="3">
                <?=$group?>
            </td>
        </tr>
    </table>
</div>




<div class="analiz-results">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'header'=>'№'],
            'pokaz_id'=>[
                'header'=>'ВИД АНАЛИЗА',
                'attribute'=>'pokaz_id',
                'value' => function ($data) {
                        return SPokazatel::getName($data->pokaz_id);                    
                }
            ],
            [
                'header'=>'ЕД. ИЗМ.',
                'value' => function ($data) {
                        return SPokazatel::getAdd1UlchBirligi($data->pokaz_id);                    
                }
            ],
            [
                'header'=>'НОРМА',
                'value' => function ($data) {
                        return PokazLimits::getNorma($data->main_id,$data->pokaz_id);                    
                }
            ],
            [
                'header'=>'МИН',
                'value' => function ($data) {
                        return PokazLimits::getMin($data->main_id,$data->pokaz_id);                    
                }
            ],
            [
                'header'=>'МАКС',
                'value' => function ($data) {
                        return PokazLimits::getMax($data->main_id,$data->pokaz_id);                    
                }
            ],
            'reslut_value'=>[
                'header'=>'РЕЗУЛЬТАТ',
                'attribute' => 'reslut_value',
                'format' => 'html',
                'contentOptions' => function ($data) {
                    return  PokazLimits::getClassByValue($data->main_id,$data->pokaz_id,$data->reslut_value);
                },
                'value' => function ($data) {
                    return $data->reslut_value;
                }
            ],
        ],
    ]); ?>
</div>

</div>

<style type="text/css">
    @page *{
        margin-top: 0cm;
        margin-bottom: 0cm;
        margin-left: 0cm;
        margin-right: 0cm;
    }
    body{
        margin: 0;
    }

    .content-top-table-div table{
        width: 100%;
    }
    .bold{
        font-weight: bold;
    }
    .summary{
        display: none;
    }

    table.table{
        border-spacing: 0;
        width: 100%;
    }
    table.table td{
        text-align: center;
    }
    table.table td, table.table th{
        border: 1px solid black;
        padding: 5px;
        font-size: 10px;
    }
    table.table td:nth-child(2){
        width: 40%;
        text-align: left;
        font-weight: bold;
    }

    .bg-danger{
        background-color: #FF808099;
    }
    .bg-success{
        background-color: #61E35D99;
    }
<?php
    if($group=='ОБЩИЙ АНАЛИЗ КРОВИ'){
?>
    table.table th{
        background-color: silver;
        padding: 5px
    }
    .table_analiz, .table_client{
        margin-top: 2px;
    }
    .analiz-results{
        margin-top: 10px;
    }
    .name-of-analiz{
        font-size: 10px;
        font-weight: bold;
        color: gray;
        text-align: center;
    }
<?php
    }
    else{
?>
    table.table th{
        background-color: silver;
        padding: 5px 10px;
        font-size: 10px;
    }
    .table_analiz, .table_client{
        margin-top: 2px;
    }
    .analiz-results{
        margin-top: 10px;
    }
    .name-of-analiz{
        font-size: 10px;
        font-weight: bold;
        color: gray;
        text-align: center;
    }
<?php
    }
?>


.table_client{
    font-size: 10px;
}
.adress{
    font-size: 10px;
    text-align: center;
    padding-left: 50px;
}
.tb-header{
    margin: 0 auto;
}
</style>





