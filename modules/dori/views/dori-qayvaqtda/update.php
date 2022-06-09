<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\dori\models\DoriQayvaqtda */

$this->title = 'Ўзгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ўзгартириш';
?>
<div class="dori-qayvaqtda-update card">
    <div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
