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

    

<?php
    if(Yii::$app->user->getRole()==1){
?>
    <p>
        <?= Html::a('Янги', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            ['class' => 'yii\grid\ActionColumn'],

            [
                'header'=>'Хисоб',
                'format'=>'raw',
                'value' => function ($data) {
                        return Html::a('Хисоб', ['hisob', 'id'=>$data->id]);
                }
            ]
        ],
    ]); ?>
<?php
    }
    else{
?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                    if(Yii::$app->user->getRole()==6&&$data->id==8){
                        $str = '<br>'.Html::a('Пулни юбориш', ['send', 'id'=>$data->id]);
                    }
                    else{
                        $str = '';
                    }
                    
                    return Html::a('Хисоб', ['hisob', 'id'=>$data->id]).$str;
                }
            ]
        ],
    ]); ?>
<?php
    }
?>
    </div>
</div>
