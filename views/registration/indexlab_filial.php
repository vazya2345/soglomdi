<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Client;
use app\models\Users;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'other'=>[
                'attribute' => 'other',
                'headerOptions' => ['style' => 'width:4%'],
            ],
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
           [
                'label'=>'Мижоз тел рақами',
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
            // 'sum_amount',
            //'sum_cash',
            //'sum_plastik',
            //'sum_debt',
            //'add1',
            // 'natija_input'=>[
            //     'attribute'=>'natija_input',
            //     'filter'=>[0=>'Очиқ',1=>'Якунланди'],
            //     'value' => function ($data) {
            //             return (strlen($data->natija_input)>0 ? ($data->natija_input==1 ? 'Якунланди' : 'Очиқ') : 'Очиқ');                    
            //     }
            // ],
            // //'other',
            // 'create_date',
            'lab_vaqt',
            'status'=>[
                'attribute'=>'status',
                'filter'=>[1=>'Янги',2=>'Рад этилди',3=>'Амалиётда',4=>'Якунланди'],
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
                    $arr = [1=>'Янги',2=>'Рад этилди',3=>'Амалиётда',4=>'Якунланди'];
                    return $arr[$data->status];
                }
            ],
            'user_id'=>[
                'attribute'=>'user_id',
                'value' => function ($data) {
                        return Users::getNameAndFil($data->user_id);                    
                }
            ],
            //'change_time',
            [
                'header' => 'Натижа', 
                'format' => 'raw',
                'value' => function ($data) {
                        if($data->status==1){
                        	$str = Html::a('Натижа', ['resultlab', 'id' => $data->id]);
                        	$str .= "<br>".Html::a('Қабул қилиш', ['labqabul', 'id' => $data->id]);
                        	$str .= "<br>".Html::a('Рад этиш', ['labrad', 'id' => $data->id], [
					            'data' => [
					                'confirm' => 'Янги вақт киритишингиз керак бўлади. Розимисиз?',
					                'method' => 'post',
					            ],
					        ]);
                        }
                        else{
                        	$str = Html::a('Натижа', ['resultlab', 'id' => $data->id]);
                        }
                        // $str = Html::a('Натижа', ['resultlab', 'id' => $data->id]);
                        return $str;
                }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>


<?php

?>