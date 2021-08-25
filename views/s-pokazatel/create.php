<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SPokazatel */

$this->title = 'Янги';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spokazatel-create card">
    <div class="card-body">

    <?php 
    	if(isset($analiz_id)){
    		echo $this->render('_form', [
		        'model' => $model,
		        'analiz_id' => $analiz_id,
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
