<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Фойдаланувчи кушиш';
$this->params['breadcrumbs'][] = ['label' => 'Фойдаланувчилар', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create card">
	<div class="card-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
