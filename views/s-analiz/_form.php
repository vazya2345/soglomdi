<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SGroups;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $model app\models\SAnaliz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sanaliz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <?= $form->field($model, 'ord')->textInput() ?>

    <?= $form->field($model, 'add1')->textInput() ?>

    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'group_id')->dropDownList(SGroups::getAll()) ?>

    <?= $form->field($model, 'is_fil')->dropDownList([0=>'Фақат бош офис',1=>'Филиалда хам']) ?>

    <?= $form->field($model, 'lab_user_id')->dropDownList(Users::getAllLabs()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
