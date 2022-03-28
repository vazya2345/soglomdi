<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OylikUderjSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ушланмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-uderj-index card">
    <div class="card-body">

    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'oylik_hodimlar_id',
            'title',
            'summa',
            'period',
            //'create_date',
            //'create_userid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
