<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QarzQaytarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Qarz Qaytars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qarz-qaytar-index card">
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
            'reg_id',
            'summa_plasitk',
            'summa_naqd',
            'qaytargan_vaqt',
            //'kassir_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
