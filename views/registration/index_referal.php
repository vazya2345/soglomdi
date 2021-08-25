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
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            'sum_amount',
            'sum_debt',
            'skidka_reg',
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
            //'change_time',
            [
                'header' => 'Натижа', 
                'format' => 'raw',
                'value' => function ($data) {
                    $str = Html::a('Натижа', ['result', 'id' => $data->id]);
                    return $str;
                }
            ],
        ],
    ]); ?>

    </div>
</div>


<?php

?>