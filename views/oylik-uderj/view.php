<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\OylikHodimlar;
use app\models\OylikUderjTypes;
/* @var $this yii\web\View */
/* @var $model app\models\OylikUderj */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="oylik-uderj-view card">
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
            'oylik_hodimlar_id' => [
                'attribute'=>'oylik_hodimlar_id',
                'filter'=>OylikHodimlar::getAll(),
                'value' => function ($model) {
                        return OylikHodimlar::getName($model->oylik_hodimlar_id);                    
                }
            ],
            'title' => [
                'attribute'=>'title',
                'filter'=>OylikUderjTypes::getAll(),
                'value' => function ($model) {
                        return OylikUderjTypes::getName($model->title);                    
                }
            ],
            'summa',
            'period',
            'create_date',
            'create_userid',
        ],
    ]) ?>
    </div> 
</div>
