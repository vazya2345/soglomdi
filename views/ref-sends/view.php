<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Users;
use app\models\Referals;
/* @var $this yii\web\View */
/* @var $model app\models\RefSends */

$this->title = $model->refnum;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ref-sends-view card">
    <div class="card-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'refnum'=>[
                'attribute'=>'refnum',
                'value' => function ($model) {
                    return Referals::getNameByRefnum($model->refnum).' - '.$model->refnum;
                }
            ],
            'sum',
            'status'=>[
                'attribute'=>'status',
                'value' => function ($model) {
                    return $model->status==1 ? 'Юборилди' : 'Қабул қилинди';
                }
            ],
            'send_date',
            'rec_date',
            'user_id'=>[
                'attribute'=>'user_id',
                'value' => function ($model) {
                    return Users::getNameAndFil($model->user_id);
                }
            ],
        ],
    ]) ?>
    </div>
</div>
