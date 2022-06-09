<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\consultation\models\ConsultationDoriReceptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ёзилган рецептлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-dori-recept-index card">
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
            'reg_id',
            'dori_title',
            'dori_doza',
            'dori_shakli',
            //'dori_mahali',
            //'dori_davomiyligi',
            //'dori_qabul',
            //'dori_qayvaqtda',
            //'create_date',
            //'create_userid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
