<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OylikShakl */

$this->title = 'Create Oylik Shakl';
$this->params['breadcrumbs'][] = ['label' => 'Oylik Shakls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oylik-shakl-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
