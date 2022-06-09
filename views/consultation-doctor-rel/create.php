<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConsultationDoctorRel */

$this->title = 'Create Consultation Doctor Rel';
$this->params['breadcrumbs'][] = ['label' => 'Consultation Doctor Rels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-doctor-rel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
