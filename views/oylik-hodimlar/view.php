<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $model app\models\OylikHodimlar */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="oylik-hodimlar-view card">
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
            'fio',
            'summa',
            'filial_id' => [
                'attribute'=>'filial_id',
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);                    
                }
            ],
            'lavozim',
            'other_info',
            'create_date',
        ],
    ]) ?>
    </div>
</div>
