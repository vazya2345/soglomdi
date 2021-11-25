<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Registration;
use app\models\Client;
use app\models\Users;
use app\models\Filials;
use app\models\SendSms;
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

            // 'other'=>[
            //     'attribute' => 'other',
            //     'headerOptions' => ['style' => 'width:6%'],
            // ],
            [
                'attribute'=>'user_id',
                'header'=>'Филиал',
                'headerOptions' => ['style' => 'width:5%'],
                'filter' => Filials::getAll(),
                'value' => function ($data) {
                        return Filials::getName(Users::getFilial($data->user_id));                    
                }
            ],
            'client_id'=>[
                'attribute'=>'client_id',
                'headerOptions' => ['style' => 'width:25%'],
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            [
                'header'=>'Тел рақами',
                'headerOptions' => ['style' => 'width:5%'],
                'value' => function ($data) {
                        return Client::getPhonenumforsms($data->client_id);                    
                }
            ],
            // 'user_id',
            'sum_amount'=>[
                'attribute'=>'sum_amount',
                'headerOptions' => ['style' => 'width:6%'],
                'value' => function ($data) {
                    if($data->sum_amount>0){
                        return number_format($data->sum_amount);                    
                    }
                    else{
                        return 0;
                    }
                }
            ],
            
            'sum_cash'=>[
                'attribute'=>'sum_cash',
                'headerOptions' => ['style' => 'width:6%'],
                'value' => function ($data) {
                    if($data->sum_cash>0){
                        return number_format($data->sum_cash);                    
                    }
                    else{
                        return 0;
                    }
                }
            ],
            'sum_plastik'=>[
                'attribute'=>'sum_plastik',
                'headerOptions' => ['style' => 'width:6%'],
                'value' => function ($data) {
                    if($data->sum_plastik>0){
                        return number_format($data->sum_plastik);                    
                    }
                    else{
                        return 0;
                    }
                }
            ],
            'skidka_reg'=>[
                'attribute'=>'skidka_reg',
                'headerOptions' => ['style' => 'width:6%'],
                'value' => function ($data) {
                    if($data->skidka_reg>0){
                        return number_format($data->skidka_reg);                    
                    }
                    else{
                        return 0;
                    }
                }
            ],
            'sum_debt'=>[
                'attribute'=>'sum_debt',
                'headerOptions' => ['style' => 'width:6%'],
                'value' => function ($data) {
                    if($data->sum_debt>0){
                        return number_format($data->sum_debt);                    
                    }
                    else{
                        return 0;
                    }
                }
            ],
            //'ref_code',
            
            //'other',
            'create_date',
            //'change_time',
            'natija_input'=>[
                'attribute'=>'natija_input',
                'filter'=>[0=>'Очиқ',1=>'Якунланди'],
                'value' => function ($data) {
                        return (strlen($data->natija_input)>0 ? ($data->natija_input==1 ? 'Якунланди' : 'Очиқ') : 'Очиқ');                    
                }
            ],
            [
                'header' => 'Охирги юборилган вақт', 
                'format' => 'raw',
                'value' => function ($data) {
                        return SendSms::getLastDateForQarzByPhonenum(Client::getPhonenumforsms($data->client_id));
                }
            ],
            [
                'header' => 'СМС', 
                'format' => 'raw',
                'value' => function ($data) {
                        $text = 'Assalomu alaykum, hurmatli mijoz. Sizning Sog`lom diagnostikadan qarzingiz {QARZSUM} so`mni tashkil qiladi. Iltimos qarzdorlikni to`lab qo`ying. Tel: 95-2040150';
                        $text = str_replace('{QARZSUM}', $data->sum_debt, $text);
                        return Html::a(
                                        'Юбориш', 
                                        ['sendqarzsmsact', 'id'=>$data->id], 
                                        [ 
                                            'data' => [
                                                'confirm' => Client::getPhonenumforsms($data->client_id).' рақамга "'.$text.'" хабарни юбормоқчимисиз?',
                                            ]
                                        ]
                        );

                }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
