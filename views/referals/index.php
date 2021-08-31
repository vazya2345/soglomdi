<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReferalsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рефераллар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referals-index card">
    <div class="card-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'filial'=>[
                'attribute'=>'filial',
                'filter'=>Filials::getAll(),
                'value' => function ($data) {
                    return Filials::getName($data->filial);
                }
            ],
            'refnum',
            // 'id',
            'fio',
            // 
            // 'user_id',
            'desc',
            //'info:ntext',
            //'add1',
            'phone',


            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{view}',
            // ],
        ],
    ]); ?>

    </div>
</div>
