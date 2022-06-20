<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\consultation\models\ConsultationOperationList */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="consultation-operation-list-view card">
    <div class="card-body">
    <p>
        <?= Html::a('Ўзгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Ўчириш', ['delete', 'id' => $model->id], [
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
            'title',
            'info:ntext',
            'group',
            'price',
        ],
    ]) ?>
    </div>
</div>