<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\SAnaliz;

$pokazs = SPokazatel::getPokazs($model->analiz_id);

$this->title = 'Натижа киритиш';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registration-index card">
    <div class="card-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            'user_id',
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'value' => function ($data) {
                        return SAnaliz::getName($data->analiz_id);                    
                }
            ],
            'sum_amount',
            'sum_cash',
            'sum_plastik',
            'sum_debt',
            // 'add1',
            // 'add2',
            // 'other',
            'create_date',
            'change_time',
        ],
    ]) ?>
    </div>
</div>
<div class="card">
    <div class="card-body">
    <?= Html::beginForm(['registration/save', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'main_id',
            // 'analiz_id',
            'pokaz_id'=>[
                'attribute'=>'pokaz_id',
                'value' => function ($data) {
                        return SPokazatel::getName($data->pokaz_id);                    
                }
            ],
            'reslut_value'=>[
                'attribute'=>'reslut_value',
                'format'=>'raw',
                'value' => function ($data) {
                        return Html::input('text', 'pokaz['.$data->id.']', $data->reslut_value, ['class' => 'form-control']);                    
                }
            ],
            //'result_answer',
            //'create_date',
            //'user_id',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?= Html::submitButton('Якунлаш', ['class' => 'btn btn-primary float-right']) ?>
    <?= Html::endForm() ?>
    </div>
</div>
