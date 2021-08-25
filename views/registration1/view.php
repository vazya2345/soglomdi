<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SAnaliz;
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="registration-view card">
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
            // 'user_id',
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'value' => function ($data) {
                        return SAnaliz::getName($data->analiz_id);                    
                }
            ],
            'sum_amount',
            // 'sum_cash',
            // 'sum_plastik',
            // 'sum_debt',
            // 'add1',
            // 'add2',
            // 'other',
            // 'create_date',
            // 'change_time',
        ],
    ]) ?>
    </div>
</div>
