<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OylikUderj */

$this->title = 'Ўзгартириш: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ўзгартириш';
?>
<div class="oylik-uderj-update card">
    <div class="card-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
