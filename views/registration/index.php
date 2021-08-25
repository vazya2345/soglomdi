<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Registration;
use app\models\Client;
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
            // ['class' => 'yii\grid\SerialColumn'],

            'other'=>[
                'attribute' => 'other',
                'headerOptions' => ['style' => 'width:6%'],
            ],
            'client_id'=>[
                'attribute'=>'client_id',
                'headerOptions' => ['style' => 'width:44%'],
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            // 'user_id',
            'sum_amount'=>[
                'attribute'=>'sum_amount',
                'headerOptions' => ['style' => 'width:18%'],
            ],
            'natija_input'=>[
                'attribute'=>'natija_input',
                'filter'=>[0=>'Очиқ',1=>'Якунланди'],
                'value' => function ($data) {
                        return (strlen($data->natija_input)>0 ? ($data->natija_input==1 ? 'Якунланди' : 'Очиқ') : 'Очиқ');                    
                }
            ],
            // 'sum_cash',
            //'sum_plastik',
            //'sum_debt',
            //'ref_code',
            //'skidka',
            //'other',
            //'create_date',
            //'change_time',
            [
                'header' => 'Натижа', 
                'format' => 'raw',
                'value' => function ($data) {
                        return Registration::getNatijaLink($data->id);
                }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
