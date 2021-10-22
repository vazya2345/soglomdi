<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rasxod */

$this->title = 'Узгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Узгартириш';
?>
<div class="rasxod-update card">
	<div class="card-body">

    <?= $this->render('_form1', [
        'model' => $model,
    ]) ?>

	</div>
</div>
