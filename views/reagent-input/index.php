<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Reagent;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReagentInputSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реагент киритиш';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-input-index card">
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
            'value',
            'create_date',
            // 'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
