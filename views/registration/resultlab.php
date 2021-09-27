<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\SAnaliz;
use app\models\InpTypes;
use app\models\InpText;
use app\models\Users;
// $pokazs = SPokazatel::getPokazs($model->analiz_id);

$this->title = 'Натижа киритиш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['indexlab']];
$this->params['breadcrumbs'][] = $this->title;

$client_model = Client::findOne($model->client_id);
?>
<div class="registration-index card">
    <div class="card-body">
    <p>
        <?= Html::a('Мижоз маълумотларини ўзгартириш', ['client/update', 'id'=>$model->client_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Танланган маълумотларини ўзгартириш', ['reg-dopinfo/updatereg', 'reg_id'=>$model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Пробирка рақамини ўзгартириш', ['registration/updatelab', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
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
            'create_date',
            'user_id'=>[
                'attribute'=>'user_id',
                'value' => function ($data) {
                        return Users::getNameAndFil($data->user_id);                    
                }
            ],
            'lab_vaqt',
        ],
    ]) ?>
    </div>
</div>

<div class="client-index card">
    <div class="card-body">
    <?= DetailView::widget([
        'model' => $$client_model,
        'attributes' => [
            'doc_seria',
            'doc_number',
            'fname',
            'lname',
            'mname',
            'birthdate',
            'sex',
            'add1',
            'address_tuman',
            'address_text',
        ],
    ]) ?>
    </div>
</div>


<div class="card" id="results">
    <div class="card-body">
    <?= Html::beginForm(['registration/save', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data']) ?>
<?php
$i = 0;
    foreach ($dataProvider as $key) {
    echo '<div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">'.$analiz_names[$i].'</h3>
                <div class="card-tools">
                    '.
                        Html::a('<i class="fas fa-download"></i>', ['print-group', 'group'=>SAnaliz::getAdd1($analizs[$i]->analiz_id), 'reg_id'=>$model->id], ['class' => 'btn btn-tool btn-sm'])
                    .'
                </div>
            </div>

            <div class="card-body">';
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
            'reslut_value'=>[
                'attribute'=>'reslut_value',
                'format'=>'raw',
                'value' => function ($data) {
                    $inptype=SPokazatel::getInpType($data->pokaz_id);
                    $inptext=InpText::getText($inptype,$data->id,$data->reslut_value);

                    
                    return $inptext;
                }
            ],
            //'result_answer',
            //'create_date',
            //'user_id',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php
    echo "</div></div>";
    $i++;
}
?>
    <?= Html::submitButton('Якунлаш', ['class' => 'btn btn-primary float-right']) ?>
    <?= Html::endForm() ?>
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
</style>


<script type="text/javascript">
    function mycheckvalue(type,id){
        var a = $('.'+type+'dataid'+id).val();
        if(a.length>0){
            if(type=='n'){
                $('.sdataid'+id).attr('disabled',true);
            }
            else{
                $('.ndataid'+id).attr('disabled',true);
            }
            
        }
        else{
            if(type=='n'){
                $('.sdataid'+id).attr('disabled',false);
            }
            else{
                $('.ndataid'+id).attr('disabled',false);
            }
        }
    }
</script>