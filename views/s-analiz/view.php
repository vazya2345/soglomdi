<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\SGroups;
/* @var $this yii\web\View */
/* @var $model app\models\SAnaliz */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sanaliz-view card">
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
            'group_id'=>[
                'attribute'=>'group_id',
                'value' => function ($model) {
                        return SGroups::getName($model->group_id);                    
                }
            ],
            'price',
            'add1',
            'is_active',
            'ord',
            'desc:ntext',
        ],
    ]) ?>
    </div>
</div>

<div class="pokazs-view card card-primary">
    <div class="card-header">
        Курсаткичлар
    </div>
    <div class="card-body">
   	<p>
        <?= Html::a('Янги кўрсаткич қўшиш', ['s-pokazatel/create1', 'analiz_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            // 'add1',
            // 'ord',

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'attribute' => 'add1',
                'format'=>'raw',
                'value' => function ($data) {
                        return Html::a('Батафсил', ['s-pokazatel/view', 'id' => $data->id], ['class' => 'profile-link']);
                }
            ],
        ],
    ]); ?>
    </div>
</div>