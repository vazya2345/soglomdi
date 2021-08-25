<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReagentFilial */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reagent-filial-create card">
	<div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
