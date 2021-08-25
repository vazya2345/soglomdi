<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VidAnaliz */

$this->title = 'Update Vid Analiz: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Vid Analizs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vid-analiz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
