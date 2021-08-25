<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Reagent;
use app\models\SAnaliz;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReagentRelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реагент боғлиқликлари';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-rel-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'reagent_id'=>[
                'attribute'=>'reagent_id',
                'filter'=>Reagent::getAll(),
                'value'=>function($data){
                    return Reagent::getName($data->reagent_id);
                }
            ],
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'filter'=>SAnaliz::getAll(),
                'value'=>function($data){
                    return SAnaliz::getName($data->analiz_id);
                }
            ],
            'soni',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
