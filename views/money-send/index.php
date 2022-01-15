<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Users;
use app\models\FilialQoldiq;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MoneySendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Юборилган пул';
$this->params['breadcrumbs'][] = $this->title;

$mybalance = FilialQoldiq::getMyBalance();
$mybalancetext = FilialQoldiq::getMyBalanceText();
?>
<div class="money-send-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['filial-qoldiq/sendmoney'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($mybalancetext, '#', ['class' => 'btn btn-primary']) ?>

    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'send_user'=>[
                'attribute'=>'send_user',
                'filter'=>Users::getAllKassirs(),
                'value' => function ($data) {
                        return Users::getName($data->send_user);
                }
            ],
            'rec_user'=>[
                'attribute'=>'rec_user',
                'filter'=>Users::getAllKassirs(),
                'value' => function ($data) {
                        return Users::getName($data->rec_user);
                }
            ],
            'amount',
            'send_type'=>[
                'attribute'=>'send_type',
                'filter'=>[1=>'Нақд',2=>'Пластик'],
                'value' => function ($data) {
                    $qoldiq_type_arr = [1=>'Нақд',2=>'Пластик'];
                    return $qoldiq_type_arr[$data->send_type];
                }
            ],
            'status'=>[
                'attribute'=>'status',
                'filter'=>[1=>'Юборилди',2=>'Қабул қилинди',3=>'Рад қилинди'],
                'value' => function ($data) {
                    $status_arr = [1=>'Юборилди',2=>'Қабул қилинди',3=>'Рад қилинди'];
                    return $status_arr[$data->status];
                }
            ],
            'send_date',
            'rec_date',
            //'desc',
            [
                'label'=>'Харакат',
                'format'=>'raw',
                'value' => function ($data) {
                    if($data->status==1&&$data->rec_user==Yii::$app->user->id){
                        if(FilialQoldiq::checkBalance($data->send_user,$data->send_type)>=$data->amount){
                            return  Html::a(
                                    'Қабул', 
                                    ['money-send/qabul', 'id' => $data->id], 
                                    [
                                        'class' => 'profile-link',
                                        'data' => [
                                            'confirm' => $data->amount.' сўм пулни қабул қилмоқдасиз. Ишончингиз комилми?',
                                            'method' => 'post',
                                        ],
                                    ] 
                                    
                                ).
                                "<br>".
                                Html::a(
                                    'Рад', 
                                    ['money-send/rad', 'id' => $data->id], 
                                    [
                                        'class' => 'profile-link',
                                        'data' => [
                                            'confirm' => $data->amount.' сўм пулни рад қилмоқдасиз. Ишончингиз комилми?',
                                            'method' => 'post',
                                        ],
                                    ]
                                    
                                );
                        }
                        else{
                            return  "<span class='lined'>Кабул</span>".
                                "<br>".Html::a(
                                    'Рад', 
                                    ['money-send/rad', 'id' => $data->id], 
                                    [
                                        'class' => 'profile-link',
                                        'data' => [
                                            'confirm' => $data->amount.' сўм пулни рад қилмоқдасиз. Ишончингиз комилми?',
                                            'method' => 'post',
                                        ],
                                    ]
                                    
                                );
                        }

                        
                    }
                    else{
                        return '';
                    }
                }
            ]

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
<style type="text/css">
    .lined{
        text-decoration: line-through;
    }
</style>