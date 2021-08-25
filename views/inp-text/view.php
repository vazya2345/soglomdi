<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\InpTypes;
/* @var $this yii\web\View */
/* @var $model app\models\InpText */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inp-text-view card">
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
            'inptype_id'=>[
                'attribute'=>'inptype_id',
                'value'=>function ($model) {
                        return InpTypes::getName($model->inptype_id);                    
                }
            ],
            'input_type',
            'input_value',
            // 'add1',
            'ord',
        ],
    ]) ?>
    </div>
</div>
