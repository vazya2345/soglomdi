<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\InpTypes;
/* @var $this yii\web\View */
/* @var $searchModel app\models\InpTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Лаборант учун маълумот киритиш справочники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inp-text-index card">
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
            'inptype_id'=>[
                'attribute'=>'inptype_id',
                'filter'=>InpTypes::getAll(),
                'value' => function ($data) {
                        return InpTypes::getName($data->inptype_id);                    
                }
            ],
            'input_type',
            'input_value',
            // 'add1',
            //'ord',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
