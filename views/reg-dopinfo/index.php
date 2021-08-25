<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegDopinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кушимча маълумот';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reg-dopinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'reg_id',
            'indikator_id',
            'value',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
