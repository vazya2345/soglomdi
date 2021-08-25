<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\PokazLimits;
use app\models\SAnaliz;

$pokazs = SPokazatel::getPokazs($model->analiz_id);

$this->title = 'Натижа';
$this->params['breadcrumbs'][] = $this->title;
?>
    

<div class="content-top-table-div">
    <table>
        <tr>
            <td class="name-of-analiz" colspan="3">
                <?=SAnaliz::getName($model->analiz_id)?>
            </td>
        </tr>
        <tr>
            <td class="bold">Пациент: <?=Client::getName($model->client_id)?></td>
            <td class="bold">Дата рождения: <?=Client::getBirthDate($model->client_id)?></td>
            <td class="bold">Дата: <?=date("d.m.Y")?></td>
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
                'header'=>'МИН',
                'value' => function ($data) {
                        return PokazLimits::getMin($data->main_id,$data->pokaz_id);                    
                }
            ],
            [
                'header'=>'НОРМА',
                'value' => function ($data) {
                        return PokazLimits::getNorma($data->main_id,$data->pokaz_id);                    
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
    }
    table.table th{
        background-color: silver;
    }
    table.table td{
        text-align: center;
    }
    table.table td, table.table th{
        border: 1px solid black;
        padding: 5px;
    }
    table.table td:nth-child(2){
        width: 50%;
        text-align: left;
        font-weight: bold;
    }
    .bg-danger{
        background-color: #FF808099;
    }
    .bg-success{
        background-color: #61E35D99;
    }
</style>