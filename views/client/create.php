<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Янги мижоз';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create card">
    <div class="card-body">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
