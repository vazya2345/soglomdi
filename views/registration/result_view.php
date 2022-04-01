<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\Users;
use app\models\SPokazatel;
use app\models\PokazLimits;
use app\models\SAnaliz;

// $pokazs = SPokazatel::getPokazs($model->analiz_id);

$this->title = 'Натижа кўриш';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="card">
    <div class="card-body">
        <p>
            <?= Html::a('Чоп этиш', ['print', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div> -->
<div class="registration-index card">
    <div class="card-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'other',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            'user_id'=>[
                'attribute'=>'user_id',
                'value' => function ($data) {
                        return Users::getNameAndFil($data->user_id);                    
                }
            ],
            
            'sum_amount',
            'sum_cash',
            'sum_plastik',
            'sum_debt',
            'skidka_reg',
            'skidka_kassa',
            // 'other',
            'create_date',
            'change_time',
        ],
    ]) ?>
    </div>
</div>
<div class="card" id="results">
    <div class="card-body">


            



<?php
$i = 0;
$group_name = '';
    foreach ($dataProvider as $key) {

        
        $j=$i-1;
        $group_name = $analiz_names[$i]['add1'];
        // var_dump($group_name);die;
        if((isset($analiz_names[$j])||$i==0)&&strlen($group_name)>0){
            if(($j<0)||($group_name!=$analiz_names[$j]['add1'])){
            // if(($group_name!=$analiz_names[$j]['add1'])){
                if($i!=0){
                    echo "</div></div>";    
                }
                echo '<div class="card card-success">';
                echo '
                        <div class="card-header border-0">
                            <h3 class="card-title">'.$group_name.'</h3>
                            <div class="card-tools">
                    '.
                        Html::a('<i class="fas fa-download"></i>', ['print-group', 'group'=>$group_name, 'reg_id'=>$model->id], ['class' => 'btn btn-tool btn-sm'])
                    .'
                            </div>
                        </div>
                ';
                echo '<div class="card-body">';
            }
        }
        elseif (isset($analiz_names[$j])&&strlen($group_name)==0) {
            echo "</div></div>";
            echo '<div class="card card-success">';
            echo '
                    <div class="card-header border-0">
                        <h3 class="card-title">'.$analiz_names[$i]['name'].'</h3>
                        <div class="card-tools">
                '.
                    Html::a('<i class="fas fa-download"></i>', ['print', 'analiz_id'=>$analiz_names[$i]['analiz'], 'reg_id'=>$model->id], ['class' => 'btn btn-tool btn-sm'])
                .'
                        </div>
                    </div>
            ';
            echo '<div class="card-body">';
        }
        else{
            echo '<div class="card card-success">';
            echo '
                    <div class="card-header border-0">
                        <h3 class="card-title">'.$analiz_names[$i]['name'].'</h3>
                        <div class="card-tools">
                '.
                    Html::a('<i class="fas fa-download"></i>', ['print', 'analiz_id'=>$analiz_names[$i]['analiz'], 'reg_id'=>$model->id], ['class' => 'btn btn-tool btn-sm'])
                .'
                        </div>
                    </div>
            ';
            echo '<div class="card-body">';
        }

    
?>
    <?= GridView::widget([
        'dataProvider' => $key,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'main_id',
            // 'analiz_id',
            'pokaz_id'=>[
                'attribute'=>'pokaz_id',
                'value' => function ($data) {
                        return SPokazatel::getName($data->pokaz_id);                    
                }
            ],
            [
                'header'=>'МИН',
                'value' => function ($data) {
                        return PokazLimits::getMin($data->main_id,$data->pokaz_id);                    
                }
            ],
            [
                'header'=>'НОРМА',
                'value' => function ($data) {
                        return PokazLimits::getNorma($data->main_id,$data->pokaz_id);                    
                }
            ],
            [
                'header'=>'МАКС',
                'value' => function ($data) {
                        return PokazLimits::getMax($data->main_id,$data->pokaz_id);                    
                }
            ],
            'reslut_value'=>[
                'attribute' => 'reslut_value',
                'format' => 'html',
                'contentOptions' => function ($data) {
                    return  PokazLimits::getClassByValue($data->main_id,$data->pokaz_id,$data->reslut_value);
                },
                'value' => function ($data) {
                    return $data->reslut_value;
                }
            ],
            //'result_answer',
            //'create_date',
            //'user_id',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php
    
    $i++;
}
?>
    </div>
</div>

    </div>
</div>
<style type="text/css">
    #results div.grid-view div.summary{
        display: none;
    }
    #results div.grid-view table thead{
        display: none;
    }
    #results div.grid-view table tbody td:nth-child(1){
        width: 5%;
    }
    #results div.grid-view table tbody td:nth-child(2){
        width: 75%;
    }
    #results div.grid-view table tbody td:nth-child(3),
    #results div.grid-view table tbody td:nth-child(4),
    #results div.grid-view table tbody td:nth-child(5),
    #results div.grid-view table tbody td:nth-child(6){
        width: 5%;
    }
</style>