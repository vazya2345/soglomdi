<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Мижоз маълумотларини ўзгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Ортга', 'url' => Yii::$app->request->referrer];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-update card">
	<div class="card-body">
	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>
	</div>
</div>
