<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Reagent;
use app\models\Filials;
/* @var $this yii\web\View */
/* @var $model app\models\ReagentSend */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reagent-send-view card">
    <div class="card-body">

    <p>
        <?= Html::a('Узгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учириш', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reagent_id'=>[
                'attribute'=>'reagent_id',
                'value' => function ($data) {
                        return Reagent::getName($data->reagent_id);                    
                }
            ],
            'filial_id'=>[
                'attribute'=>'filial_id',
                'value' => function ($data) {
                        return Filials::getName($data->filial_id);                    
                }
            ],
            'soni',
            'send_date',
            'comment:ntext',
        ],
    ]) ?>
    </div>
</div>
