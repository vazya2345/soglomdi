<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilialQoldiq */

$this->title = 'Узгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Узгартириш';
?>
<div class="filial-qoldiq-update card">
	<div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

	</div>
</div>
