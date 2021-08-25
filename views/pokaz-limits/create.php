<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PokazLimits */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pokaz-limits-create card">
    <div class="card-body">

    <?php 
    	if(isset($pokaz_id)){
    		echo $this->render('_form', [
		        'model' => $model,
		        'pokaz_id' => $pokaz_id,
		    ]);
    	}
    	else{
    		echo $this->render('_form', [
		        'model' => $model,
		    ]);
    	}
    ?>

	</div>
</div>
