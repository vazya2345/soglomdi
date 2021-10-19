<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Filials;
use app\models\Users;
use app\models\Referals;
use app\models\SRasxodTypes;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RasxodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Чиқимлар';
$this->params['breadcrumbs'][] = $this->title;


$y = date('Y');
$m = date('m');
$per_arr = [];
for ($i=1; $i <= 12; $i++) {
    if($i<10){
        $n = $y . '-0'.$i. '-' .  '01';
        $per_arr[$n] = $n;
        if($m==$i){
            $now = $n;
        }
    }
    else{
        $n = $y . '-'.$i. '-' .  '01';
        $per_arr[$n] = $n;
        if($m==$i){
            $now = $n;
        }
    }
}


?>
<div class="rasxod-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'filial_id'=>[
                'attribute'=>'filial_id',
                'filter'=> Filials::getAll(),
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);                    
                }
            ],
            'user_id'=>[
                'attribute'=>'user_id',
                'filter'=> Users::getAll(),
                'value' => function ($data) {
                        return Users::getName($data->user_id);                    
                }
            ],
            'summa',
            'sum_type'=>[
                'attribute'=>'sum_type',
                'filter'=> ['1'=>'Нақд', '2'=>'Пластик'],
                'value' => function ($data) {
                    $arr = ['1'=>'Нақд', '2'=>'Пластик'];
                    return $arr[$data->sum_type];                    
                }
            ],
            'rasxod_type'=>[
                'attribute'=>'rasxod_type',
                'filter'=> SRasxodTypes::getAll(),
                'value' => function ($data) {
                        return SRasxodTypes::getName($data->rasxod_type);                    
                }
            ],
            'rasxod_desc:ntext',
            'rasxod_period'=>[
                'attribute'=>'rasxod_period',
                'filter'=> $per_arr,
                'value' => function ($data,$per_arr) {
                        return $data->rasxod_period;                    
                }
            ],
            'status'=>[
                'attribute'=>'status',
                'filter'=> ['1'=>'Юборилди', '2'=>'Қабул қилинди'],
                'value' => function ($data) {
                    $arr = ['1'=>'Юборилди', '2'=>'Қабул қилинди'];
                    return $arr[$data->status];                    
                }
            ],
            'send_user'=>[
                'attribute'=>'send_user',
                'filter'=> Users::getAll(),
                'value' => function ($data) {
                        return Users::getName($data->send_user);                    
                }
            ],

            'referal_id'=>[
                'attribute'=>'referal_id',
                'filter'=> Referals::getAll(),
                'value' => function ($data) {
                        return Referals::getNameByRefnum($data->referal_id);                    
                }
            ],
            // 'referal_id',

            [
                'label'=>'Харакат',
                'format'=>'raw',
                'value' => function ($data) {
                    if($data->status==1&&Yii::$app->user->getRole()==9){
                        return  Html::a(
                                    'Қабул', 
                                    ['rasxod/qabul', 'id' => $data->id], 
                                    [
                                        'class' => 'profile-link',
                                        'data' => [
                                            'confirm' => 'Ишончингиз комилми?',
                                            'method' => 'post',
                                        ],
                                    ] 
                                    
                                ).
                                "<br>".
                                Html::a(
                                    'Рад', 
                                    ['rasxod/rad', 'id' => $data->id], 
                                    [
                                        'class' => 'profile-link',
                                        'data' => [
                                            'confirm' => 'Ишончингиз комилми?',
                                            'method' => 'post',
                                        ],
                                    ]
                                    
                                );
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
