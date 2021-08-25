<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\PokazLimits;
use app\models\SAnaliz;

$pokazs = SPokazatel::getPokazs($analiz_id);

$this->title = 'Натижа';
$this->params['breadcrumbs'][] = $this->title;
?>
    

<div class="content-top-table-div">
    <table class="table_client">
        <tr>
            <td class="bold">Пациент: <?=Client::getName($model->client_id)?></td>
            <td class="bold">Дата рождения: <?=Client::getBirthDate($model->client_id)?></td>
            <td class="bold">Дата1: <?=Result::getMaxDate($model->id)?></td>
        </tr>
    </table>
    <table class="table_analiz">
        <tr>
            <td class="name-of-analiz" colspan="3">
                <?=SAnaliz::getName($analiz_id)?>
            </td>
        </tr>
    </table>
</div>




<div class="analiz-results">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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


<style type="text/css">
    .content-top-table-div table{
        width: 100%;
    }
    .name-of-analiz{
        font-size: 24px;
        font-weight: bold;
        color: gray;
        text-align: center;
    }
    .bold{
        font-weight: bold;
    }
    .summary{
        display: none;
    }
    .analiz-results{
        margin-top: 30px;
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
    }
    table.table th{
        background-color: silver;
        padding: 10px;
    }
    table.table td:nth-child(2){
        width: 40%;
        text-align: left;
        font-weight: bold;
    }
    .table_analiz, .table_client{
        margin-top: 20px;
    }
    .bg-danger{
        background-color: #ff75ff99;
    }
    .bg-success{
        background-color: #61E35D99;
    }
</style>