<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Reagent;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReagentNotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реагент огохлантирувлари рўйхати';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-notifications-index card">
    <div class="card-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'reagent_id'=>[
                'attribute'=>'reagent_id',
                'filter'=>Reagent::getAll(),
                'format'=>'raw',
                'value' => function ($data) {
                    if(Reagent::isBirMarta($data->reagent_id)){
                        return Html::a(Reagent::getName($data->reagent_id),['reagent/view', 'id'=>$data->reagent_id]);
                    }
                    else{
                        return Html::a(Reagent::getName($data->reagent_id),['reagent-filial/index', 'ReagentFilialSearch[filial_id]'=>$data->filial_id, 'ReagentFilialSearch[reagent_id]'=>$data->reagent_id]);   
                    }
                }
            ],
            'filial_id'=>[
                'attribute'=>'filial_id',
                'filter'=>Filials::getAll(),
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);
                }
            ],
            'create_date',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
