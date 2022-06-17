<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\OylikHodimlar;
use app\models\OylikUderjTypes;
use app\models\OylikUderj;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OylikUderjSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ушланмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-uderj-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'oylik_hodimlar_id' => [
                'attribute'=>'oylik_hodimlar_id',
                'filter'=>OylikHodimlar::getAll(),
                'value' => function ($data) {
                        return OylikHodimlar::getName($data->oylik_hodimlar_id);                    
                }
            ],
            'title' => [
                'attribute'=>'title',
                'filter'=>OylikUderjTypes::getAll(),
                'value' => function ($data) {
                        return OylikUderjTypes::getName($data->title);                    
                }
            ],
            'summa',
            'status' => [
                'attribute'=>'status',
                'filter'=>OylikUderj::statusList(),
                'value' => function ($data) {
                        return OylikUderj::statusList()[$data->status];                    
                }
            ],
            'period',
            //'create_date',
            //'create_userid', 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
