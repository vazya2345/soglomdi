<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VidAnalizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vid Analizs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vid-analiz-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Vid Analiz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'analiz_id',
            'title',
            'sec_text',
            'type',
            //'ord',
            //'add1',
            //'ed_izm',
            //'kolkach',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
