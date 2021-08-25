<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Client */
/* @var $form yii\widgets\ActiveForm */
$tumans = [
'Андижон шахри'=>'Андижон шахри',
'Хонобод шахри'=>'Хонобод шахри',
'Олтинкўл тумани'=>'Олтинкўл тумани',
'Андижон тумани'=>'Андижон тумани',
'Асака тумани'=>'Асака тумани',
'Балиқчи тумани'=>'Балиқчи тумани',
'Бўстон тумани'=>'Бўстон тумани',
'Булоқбоши тумани'=>'Булоқбоши тумани',
'Жалақудуқ тумани'=>'Жалақудуқ тумани',
'Избоскан тумани'=>'Избоскан тумани',
'Қўрғонтепа тумани'=>'Қўрғонтепа тумани',
'Мархамат тумани'=>'Мархамат тумани',
'Пахтаобод тумани'=>'Пахтаобод тумани',
'Улуғнор тумани'=>'Улуғнор тумани',
'Хўжаобод тумани'=>'Хўжаобод тумани',
'Шахрихон тумани'=>'Шахрихон тумани',
'Бошка вилоят'=>'Бошка вилоят',
];
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->textInput(['type'=>'date','required'=>true]) ?>

    <?= $form->field($model, 'sex')->dropDownList(['M' =>'Эркак', 'F' =>'Аёл']) ?>

    <?= $form->field($model, 'doc_seria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add1')->textInput(['type'=>'tel', 'maxlength' => 13, 'value' => '+998', 'pattern' => '+998-[0-9]{3}-[0-9]{2}-[0-9]{2}', 'title' => 'Телефон рақамини +998-99-999-99-99 форматида киритинг', 'class' => 'form-control', 'required'=>true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_tuman')->dropDownList(['' => 'Танланг...']+$tumans) ?>

    <?= $form->field($model, 'address_text')->textInput(['maxlength' => true]) ?>

    <input type="hidden" name="return_url" value="<?=Yii::$app->request->referrer?>">

    <div class="form-group">
        <?= Html::submitButton('Саклаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
