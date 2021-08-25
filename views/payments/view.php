<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Payments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payments-view card">
    <div class="card-body">

 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'main_id',
            'cash_sum',
            'plastik_sum',
            'create_date',
            'kassir_id',
        ],
    ]) ?>
    </div>
</div>
