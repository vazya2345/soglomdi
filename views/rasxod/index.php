<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RasxodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rasxods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rasxod-index card">
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
            'filial_id',
            'user_id',
            'summa',
            'sum_type',
            //'rasxod_type',
            //'rasxod_desc:ntext',
            //'rasxod_period',
            //'status',
            //'send_user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
