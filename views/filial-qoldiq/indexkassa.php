<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Filials;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FilialQoldiqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Касса';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filial-qoldiq-index card">
    <div class="card-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'filial_id'=>[
                'attribute'=>'filial_id',
                'filter'=>Filials::getAll(),
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);
                }
            ],
            'kassir_id'=>[
                'attribute'=>'kassir_id',
                'filter'=>Users::getAllKassirs(),
                'value' => function ($data) {
                        return Users::getName($data->kassir_id);
                }
            ],
            'qoldiq',
            'last_change_date',
            [
                'header'=>'Хисоб',
                'format'=>'raw',
                'value' => function ($data) {
                        return Html::a('Хисоб', ['hisob', 'id'=>$data->id]);
                }
            ],
            [
                'header'=>'Пулни юбориш',
                'format'=>'raw',
                'value' => function ($data) {
                        return Html::a('Пулни юбориш', ['send', 'id'=>$data->id],[
                            'data' => [
                                'confirm' => 'Сиз '.$data->qoldiq.' сўм юбормоқчисиз. Ишончингиз комилми?',
                            ]

                        ]);
                }
            ]
        ],
    ]); ?>

    </div>
</div>
