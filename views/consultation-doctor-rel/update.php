<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultationDoctorRel */

$this->title = 'Update Consultation Doctor Rel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Consultation Doctor Rels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="consultation-doctor-rel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
