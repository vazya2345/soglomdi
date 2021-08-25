<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фойдаланувчи роллари';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index card">
    <div class="card-body">
    

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'group',
            // 'add1',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>

</div>
