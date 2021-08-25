<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReagentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реагентлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-index card">
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
            'qoldiq',
            'martalik',
            'price',
            'notific_count',
            'notific_filial',

            // 'add1',
            //'check',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

    </div>
</div>
