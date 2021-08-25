<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Filials;
use app\models\Reagent;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReagentFilialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реагент филиал қолдиқлари';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-filial-index card">
    <div class="card-body">

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
            'qoldiq',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
