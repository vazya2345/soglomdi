<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = 'Узгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Узгартириш';
?>
<div class="registration-update card">
	<div class="card-body">

    <div class="registration-form">

	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'status')->textInput(['type' => 'hidden', 'value'=>'2']) ?>

	    <?= $form->field($model, 'lab_vaqt')->textInput(['type' => 'datetime-local']) ?>

	    <div class="form-group">
	        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


	</div>
</div>
