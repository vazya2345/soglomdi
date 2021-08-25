<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Барча тўловлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payments-index card">
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
            'main_id'=>[
                'attribute' => 'main_id',
                'format' => 'raw',
                'value' => function ($data) {
                        return Html::a($data->main_id, ['registration/view', 'id' => $data->main_id], ['target'=>'_blank']);
                }
            ],
            'cash_sum',
            'plastik_sum',
            'create_date',
            'kassir_id'=>[
                'attribute' => 'kassir_id',
                'filter' => Users::getAllKassirs(),
                'value' => function ($data) {
                        return Users::getName($data->kassir_id);                    
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>

    </div>
</div>
