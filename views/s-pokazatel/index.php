<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SAnaliz;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SPokazatelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тахлил критерийлари';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spokazatel-index card">
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
            'title',
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'filter'=>SAnaliz::getAll(),
                'value' => function ($data) {
                        return SAnaliz::getName($data->analiz_id);                    
                }
            ],
            // 'add1',
            'ord',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
