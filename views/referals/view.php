<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Filials;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\Referals */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$umodel = Users::find()->where(['other'=>$model->refnum])->one();
?>
<div class="referals-view card">
    <div class="card-body">

    <p>
        <?= Html::a('Узгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Хисоб', ['hisob', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a('Учириш', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ],
        ]); */ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fio',
            'phone',
            'user_id',
            'filial'=>[
                'attribute'=>'filial',
                'value'=>function ($data) {
                    return Filials::getName($model->filial);
                }
            ],
            'desc',
            'info:ntext',
            'add1',
            'refnum',
            'avans_sum',
            'plastik_number',
            'plastik_date',
            'plastik_name',
            'create_date',
            'qoldiq_summa',
            'last_change_date',
        ],
    ]) ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
    <?php
        if($umodel){
            echo 
                DetailView::widget([
                    'model' => $umodel,
                    'attributes' => [
                        'login',
                        'password',
                        'mobile',
                        'add1'=>[
                            'attribute'=>'add1',
                            'value'=>function ($data) {
                                return Filials::getName($model->add1);
                            }
                        ],
                    ],
                ]);
        }
        else{
            echo '<p>Ушбу рефералга тизим фойдаланувчиси яратилмаган. '.Html::a('Яратиш', ['users/create'], ['class' => 'btn btn-primary']).'</p>';
        }
    ?>

    </div>
</div>