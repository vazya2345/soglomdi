<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name. 'га узгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Узгартириш';
?>
<div class="role-update card">
    <div class="card-body">

        <div class="users-form">
            <?php
                if(isset($_GET['err'])&&$_GET['err']=='success'){
                    echo '
                        <div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <h5><i class="icon fas fa-check"></i> Ўзгартирилди!</h5>
                          Пароль мувофақиятли ўзгартирилди.
                        </div>
                    ';
                }
            ?>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

            

            <div class="form-group">
                <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

	</div>
</div>



