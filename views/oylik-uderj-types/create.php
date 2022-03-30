<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OylikUderjTypes */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-uderj-types-create card">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
