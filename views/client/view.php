<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view card">
    <div class="card-body">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'fname',
            'lname',
            'mname',
            'birthdate',
            'sex',
            'doc_seria',
            'doc_number',
            'inn',
            'add1',
            'type',
            'address_tuman',
            'address_text',
            'user_id',
            'create_date',
            'change_date',
        ],
    ]) ?>
    </div>
</div>
