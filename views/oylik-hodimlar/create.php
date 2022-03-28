<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OylikHodimlar */

$this->title = 'Янги ходим қўшиш';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-hodimlar-create card">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
