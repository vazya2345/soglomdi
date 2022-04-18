<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SystemVariables */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-variables-create card">
    <div class="card-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    </div>
</div>
