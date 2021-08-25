<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Filials;
use app\models\Reagent;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReagentSendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реагент филиалларга жўнатмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-send-index card">
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
                'filter'=>Filials::getAll(),
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);
                }
            ],
            'reagent_id'=>[
                'attribute'=>'reagent_id',
                'filter'=>Reagent::getAll(),
                'value' => function ($data) {
                        return Reagent::getName($data->reagent_id); 
                }
            ],
            'soni',
            'send_date',
            //'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
