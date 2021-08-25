<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name. 'га узгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Узгартириш';
?>
<div class="role-update card">
    <div class="card-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
