<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\consultation\models\ConsultationAnnestezyList */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-annestezy-list-create card">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
