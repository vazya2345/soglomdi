<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\consultation\models\ConsultationAnnestezyListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аннестезиялар рўйхати';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-annestezy-list-index card">
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
            'title',
            'info:ntext',
            'group',
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
