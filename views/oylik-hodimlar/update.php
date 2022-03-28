<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OylikHodimlar */

$this->title = 'Ўзгартириш: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="oylik-hodimlar-update card">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
