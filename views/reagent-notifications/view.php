<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReagentNotifications */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reagent-notifications-view card">
    <div class="card-body">

    <p>
        <?= Html::a('Узгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учириш', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reagent_id',
            'filial_id',
            'create_date',
        ],
    ]) ?>
    </div>
</div>
