<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SPokazatel */

$this->title = 'Узгартириш ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Узгартириш';
?>
<div class="spokazatel-update card">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
	</div>
</div>
