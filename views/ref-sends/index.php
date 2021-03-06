<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Users;
use app\models\Referals;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RefSendsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рефералларга жўнатмалар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-sends-index card">
    <div class="card-body">



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'label'=>'Филиал',
                'value' => function ($data) {
                    return Filials::getName(Referals::getFilial($data->refnum));
                }
            ],
            'refnum'=>[
                'attribute'=>'refnum',
                'value' => function ($data) {
                    return $data->refnum;
                }
            ],
            [
                'label'=>'ФИШ',
                'value' => function ($data) {
                    return Referals::getName($data->refnum);
                }
            ],
            [
                'label'=>'Шифохона',
                'value' => function ($data) {
                    return Referals::getHospital($data->refnum);
                }
            ],
            [
                'label'=>'Телефон',
                'value' => function ($data) {
                    return Referals::getPhone($data->refnum);
                }
            ],
            'sum',
            'send_type'=>[
                'attribute'=>'send_type',
                'filter'=>[1=>'Нақд', 2=>'Пластик'],
                'value' => function ($data) {
                    $arr = [1=>'Нақд', 2=>'Пластик'];
                    return $arr[$data->send_type];
                }
            ],
            'status'=>[
                'attribute'=>'status',
                'filter'=>[1=>'Юборилди', 2=>'Қабул қилинди'],
                'value' => function ($data) {
                    return $data->status==1 ? 'Юборилди' : 'Қабул қилинди';
                }
            ],
            'send_date',
            //'rec_date',
            'user_id'=>[
                'attribute'=>'user_id',
                'filter'=>Users::getAll(),
                'value' => function ($data) {
                    return Users::getNameAndFil($data->user_id);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

    </div>
</div>
