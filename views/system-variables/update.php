<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemVariables */

$this->title = 'Ўзгартириш: ' . $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Ўзгартириш';
?>
<div class="system-variables-update card">
    <div class="card-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    </div>
</div>
