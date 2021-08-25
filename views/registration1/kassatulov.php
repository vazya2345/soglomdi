<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SAnaliz;
use yii\widgets\ActiveForm;

use app\models\FinishPayments;
$fmodel = FinishPayments::findOne($model->id);
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = 'Тулов - ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Тулов';
?>

<?php 
if($fmodel){
?>
<div class="card">
	<div class="card-body">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            // 'user_id',
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'value' => function ($data) {
                        return SAnaliz::getName($data->analiz_id);                    
                }
            ],
            'sum_amount',
            'sum_cash',
            'sum_plastik',
            'sum_debt',
            'create_date',
        ],
    ]) ?>
	</div>
</div>
<?php
}
else{
?>
<div class="card">
	<div class="card-body">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            // 'user_id',
            'analiz_id'=>[
                'attribute'=>'analiz_id',
                'value' => function ($data) {
                        return SAnaliz::getName($data->analiz_id);                    
                }
            ],
            'sum_amount',
            'create_date',
        ],
    ]) ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sum_cash')->textInput() ?>

    <?= $form->field($model, 'sum_plastik')->textInput() ?>

    <?= $form->field($model, 'sum_debt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	</div>
</div>
<?php
}

