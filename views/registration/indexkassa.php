<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Client;
use app\models\SAnaliz;
use app\models\Registration;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регистрациялар руйхати';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="registration-index card">
    <div class="card-body">
    <p>
        <?= Html::a('Янги', ['new'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'other',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            [
                'label'=>'Телефон рақами',
                'value' => function ($data) {
                        return Client::getPhonenum($data->client_id);                    
                }
            ],
            // 'user_id',
            // 'analiz_id'=>[
            //     'attribute'=>'analiz_id',
            //     'filter'=>SAnaliz::getAll(),
            //     'value' => function ($data) {
            //             return SAnaliz::getName($data->analiz_id);                    
            //     }
            // ],
            'sum_amount'=>[
                'attribute'=>'sum_amount',
                'format' => 'html',
                'contentOptions' => function ($data) {
                    return  Registration::getClassForSum($data->id);
                },
                'value' => function ($data) {
                        return $data->sum_amount;                    
                }
            ],
            'sum_cash',
            'sum_plastik',
            'sum_debt'=>[
                'attribute'=>'sum_debt',
                'format' => 'html',
                'filter' => [0=>'Барча',1=>'Қарздорлар'],
                'contentOptions' => function ($data) {
                    if($data->sum_debt>0){
                        return  ['class'=>'bg-danger'];    
                    }
                    else{
                        return  ['class'=>'bg-default'];    
                    }
                },
                'value' => function ($data) {
                        return $data->sum_debt;                    
                }
            ],
            'skidka_reg',
            // 'skidka_kassa',
            //'other',
            'create_date',
            //'change_time',
            // 'natija_input'=>[
            //     'attribute'=>'natija_input',
            //     'filter'=>[0=>'Очиқ',1=>'Якунланди'],
            //     'value' => function ($data) {
            //             return (strlen($data->natija_input)>0 ? ($data->natija_input==1 ? 'Якунланди' : 'Очиқ') : 'Очиқ');                    
            //     }
            // ],
            'lab_vaqt',
            'status'=>[
                'attribute'=>'status',
                'filter'=>[1=>'Янги',2=>'Р/Э амалиётда',3=>'Амалиётда',4=>'Якунланди'],
                'contentOptions' => function ($data) {
                    if($data->status==1){
                        return  ['class'=>'bg-default'];    
                    }
                    elseif($data->status==2){
                        return  ['class'=>'bg-danger'];    
                    }
                    elseif($data->status==3){
                        return  ['class'=>'bg-warning'];    
                    }
                    elseif($data->status==4){
                        return  ['class'=>'bg-success'];    
                    }
                    else{
                        return  ['class'=>'bg-default'];   
                    }
                },
                'value' => function ($data) {
                    $arr = [1=>'Янги',2=>'Р/Э амалиётда',3=>'Амалиётда',4=>'Якунланди'];
                    return $arr[$data->status];
                }
            ],
            [
                'header' => 'Тулов', 
                'format' => 'raw',
                'value' => function ($data) {
                        return Html::a('Тулов', ['kassatulov', 'id' => $data->id], ['class' => 'kassa-link']).'<br>'.
                        Html::a('Чек', ['kassachek', 'id' => $data->id], ['class' => 'kassa-link', 'target'=>'_blank']).'<br>'.
                        Registration::getNatijaLink($data->id);
                }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>

<style type="text/css">
    .grid-view table thead tr th:nth-child(2){
        width: 5%;
    }
    .grid-view table thead tr th:nth-child(5),.grid-view table thead tr th:nth-child(6),.grid-view table thead tr th:nth-child(7),.grid-view table thead tr th:nth-child(8),.grid-view table thead tr th:nth-child(9){
        width: 8%;
    }
    .grid-view table thead tr th:nth-child(10){
        width: 10%;
    }
</style>
