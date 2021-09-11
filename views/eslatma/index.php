<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EslatmaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Эслатмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eslatma-index card">
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
            'eslatma_text',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
