<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Role;
use app\models\Filials;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add1')->dropDownList(Filials::getAll()) ?>

    <?= $form->field($model, 'lavozim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->dropDownList(Role::getAll()) ?>

    <?= $form->field($model, 'active')->dropDownList(['1'=>'Ишда', '0'=>'Ишда эмас']) ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'img')->textInput(['type'=>'file', 'maxlength' => true]) ?>

    <?= $form->field($model, 'other')->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
