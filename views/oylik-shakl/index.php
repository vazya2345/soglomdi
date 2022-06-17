<?php

use yii\helpers\Html;
use yii\grid\GridView;


use app\models\OylikPeriods;
use app\models\OylikHodimlar;
use app\models\OylikUderj;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OylikShaklSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ойлик шаклланиши';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-shakl-index card">
    <div class="card-body">


    <p>
        <?= Html::a('Ойлик шакллантириш', ['shakllantirish'], ['class' => 'btn btn-success']) ?>
        <?php
            if(OylikUderj::find()->where(['period'=>OylikPeriods::getActivePeriod(), 'title' => '1'])->one()){
                echo '<button class="btn btn-default disabled">Аванс ушбу давр учун шакллантирилган.</button>';
            }
            else{
                echo Html::a('Аванс шакллантириш', ['avans'], ['class' => 'btn btn-success']);
            }
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'period' => [
                'attribute'=>'period',
                'filter'=>OylikPeriods::getAll(),
            ],
            'oylik_hodimlar_id' => [
                'attribute'=>'oylik_hodimlar_id',
                'filter'=>OylikHodimlar::getAll(),
                'value' => function ($data) {
                        return OylikHodimlar::getName($data->oylik_hodimlar_id);                    
                }
            ],
            // 'fio',
            // 'fil_name',
            //'lavozim',
            'title',
            'summa',
            'shakl_id' => [
                'attribute'=>'shakl_id',
                'filter'=>[1=>'Оклад', 2=>'Ушланмалар', 3=>'Қолдиқ'],
                'value' => function ($data) {
                    $arr = [1=>'Оклад', 2=>'Ушланмалар', 3=>'Қолдиқ'];
                        return $arr[$data->shakl_id];                    
                }
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    </div>
</div>
