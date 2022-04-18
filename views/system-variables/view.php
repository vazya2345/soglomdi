<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SystemVariables */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="system-variables-view card">
    <div class="card-body">

    <p>
        <?= Html::a('Ўзгартириш', ['update', 'id' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Ўчириш', ['delete', 'id' => $model->uid], [
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
            'uid',
            'value',
        ],
    ]) ?>


    </div>
</div>
