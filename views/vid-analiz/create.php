<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VidAnaliz */

$this->title = 'Create Vid Analiz';
$this->params['breadcrumbs'][] = ['label' => 'Vid Analizs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vid-analiz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
