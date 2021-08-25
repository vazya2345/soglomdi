<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RegDopinfo */

$this->title = 'Янги маълумот';
$this->params['breadcrumbs'][] = ['label' => 'Кушимча маълумот', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reg-dopinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
