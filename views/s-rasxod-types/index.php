<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SRasxodTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'S Rasxod Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="srasxod-types-index card">
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
            'title',
            'desc:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
