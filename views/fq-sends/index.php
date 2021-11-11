<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\FilialQoldiq;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FqSendsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Жўнатмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fq-sends-index card">
    <div class="card-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'fq_id',
            'fq_id'=>[
                'attribute'=>'fq_id',
                'filter'=>FilialQoldiq::getAll(),
                'value' => function ($data) {
                        return FilialQoldiq::getName($data->fq_id);
                }
            ],
            'sum',
            'send_type'=>[
                'attribute'=>'send_type',
                'filter'=>[1=>'Нақд',2=>'Пластик'],
                'value' => function ($data) {
                    $arr = [1=>'Нақд',2=>'Пластик'];
                        return $arr[$data->send_type];
                }
            ],
            'status'=>[
                'attribute'=>'status',
                'filter'=>[1=>'Жунатилди',2=>'Кабул килинди'],
                'value' => function ($data) {
                        $arr=[1=>'Жунатилди',2=>'Кабул килинди'];
                        return $arr[$data->status];
                }
            ],
            'send_date',
            'rec_date',

            [
                'header'=>'Кабул килиш',
                'format'=>'raw',
                'value' => function ($data) {
                    if(Yii::$app->user->getRole()==1){
                        if($data->fq_id==8||$data->fq_id==28){
                            if($data->status==1){
                                return Html::a('Кабул килиш', ['qabul', 'id'=>$data->id]);
                            }
                            else{
                                return 'Кабул килинди';
                            }
                        }
                        else{
                            if($data->status==1){
                                return 'Қабул қилинмади';
                            }
                            else{
                                return 'Кабул килинди';
                            }
                        }                        
                    }
                    elseif(Yii::$app->user->getRole()==6&&($data->fq_id!=8&&$data->fq_id!=28)){
                        if($data->status==1){
                            return Html::a('Кабул килиш', ['qabul', 'id'=>$data->id]);
                        }
                        else{
                            return 'Кабул килинди';
                        }
                    }
                }
            ]
        ],
    ]); ?>

    </div>
</div>
