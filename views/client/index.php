<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мижозлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index card">
    <div class="card-body">

    

    <p>
        <?= Html::a('Янги мижоз', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fname',
            'lname',
            'mname',
            'birthdate',
            'sex',
            //'doc_seria',
            //'doc_number',
            //'inn',
            //'add1',
            //'type',
            //'user_id',
            //'create_date',
            //'change_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
