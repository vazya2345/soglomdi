<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Янги роль яратиш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create card">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
