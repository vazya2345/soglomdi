<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\SGroups;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SAnalizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Анализлар рўйхати';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sanaliz-index card">
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
            'price',
            // 'is_active',
            // 'ord',
            //'desc:ntext',
            
            'group_id'=>[
                'attribute'=>'group_id',
                'filter'=>SGroups::getAll(),
                'value' => function ($data) {
                        return SGroups::getName($data->group_id);                    
                }
            ],
            'lab_user_id'=>[
                'attribute'=>'lab_user_id',
                'filter'=>Users::getAllLabs(),
                'value' => function ($data) {
                        return Users::getName($data->lab_user_id);                    
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
