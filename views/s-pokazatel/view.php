<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\SAnaliz;
use app\models\InpTypes;


/* @var $this yii\web\View */
/* @var $model app\models\SPokazatel */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="spokazatel-view card">
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
            'title',
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'value' => function ($model) {
                        return SAnaliz::getName($model->analiz_id);                    
                }
            ],
            'add1',
            // 'ord',
            'inptype_id'=>[
                'attribute'=>'inptype_id',
                'value' => function ($model) {
                        return InpTypes::getName($model->inptype_id);                    
                }
            ],
        ],
    ]) ?>
    </div>
</div>


<div class="pokazs-view card card-primary">
    <div class="card-header">
        Курсаткичлар чегаралари
    </div>
    <div class="card-body">
    <p>
        <?= Html::a('Янги кўрсаткич чегарасини қўшиш', ['pokaz-limits/create1', 'pokaz_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'indikator',
            'indikator_value',
            'norma',
            'down_limit',
            'up_limit',
            [
                'attribute' => 'add1',
                'format'=>'raw',
                'value' => function ($data) {
                        return Html::a('Батафсил', ['pokaz-limits/view', 'id' => $data->id], ['class' => 'profile-link']);
                }
            ],
        ],
    ]); ?>
    </div>
</div>