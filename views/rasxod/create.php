<?php

use yii\helpers\Html;
use app\models\FilialQoldiq;
/* @var $this yii\web\View */
/* @var $model app\models\Rasxod */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$mybalance = FilialQoldiq::getMyBalance();
$mybalancetext = FilialQoldiq::getMyBalanceText();

// var_dump($model);die;
?>
<div class="rasxod-create card">
	<div class="card-body">

     <p>
        <?= Html::a($mybalancetext, '#', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Балансингиздаги пул миқдоридан ортиқ чиқим қила олмайсиз. Балансингизда пул етмаётган тақдирда Завкассага мурожат қилинг.', '#', ['class' => 'btn btn-default']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'mybalance' => $mybalance,
        'oylikuderj_model' => $oylikuderj_model,
    ]) ?>
	</div>
</div>
