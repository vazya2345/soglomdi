<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OylikHodimlarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ходимлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-hodimlar-index card">
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
            'fio',
            'summa',
            'filial_id' => [
                'attribute'=>'filial_id',
                'filter'=>Filials::getAll(),
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);                    
                }
            ],
            'lavozim',
            'other_info' => [
                'attribute'=>'other_info',
                'filter'=>[1=>'Ха',0=>'Йўқ'],
                'value' => function ($data) {
                    $arr = [1=>'Ха',0=>'Йўқ'];
                    return $arr[$data->other_info];                    
                }
            ],
            //'create_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
