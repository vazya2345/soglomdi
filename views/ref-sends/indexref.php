<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Users;
use app\models\Referals;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RefSendsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рефералларга жўнатмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-sends-index card">
    <div class="card-body">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            // 'refnum'=>[
            //     'attribute'=>'refnum',
            //     'filter'=>Referals::getAll(),
            // ],
            'sum',
            'status'=>[
                'attribute'=>'status',
                'filter'=>[1=>'Юборилди', 2=>'Қабул қилинди'],
                'value' => function ($data) {
                    return $data->status==1 ? 'Юборилди' : 'Қабул қилинди';
                }
            ],
            'send_date',
            //'rec_date',
            'user_id'=>[
                'attribute'=>'user_id',
                'value' => function ($data) {
                    return Users::getNameAndFil($data->user_id);
                }
            ],

            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{view}',
            // ],
        ],
    ]); ?>

    </div>
</div>
