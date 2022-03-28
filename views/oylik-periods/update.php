<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OylikPeriods */

$this->title = 'Ўзгартириш: ' . $model->period;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->period, 'url' => ['view', 'id' => $model->period]];
$this->params['breadcrumbs'][] = 'Ўзгартириш';
?>
<div class="oylik-periods-update card">
    <div class="card-body">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
