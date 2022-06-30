<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\OylikHodimlar;
use app\models\OylikPeriods;
use app\models\OylikUderjTypes;
/* @var $this yii\web\View */
/* @var $model app\models\OylikUderj */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="oylik-uderj-form"> 

    <?php $form = ActiveForm::begin(); ?>


    <div class="form-group field-oylikuderj-oylik_hodimlar_id required">
        <label class="control-label" for="oylikuderj-oylik_hodimlar_id">Ходим</label>
            <?= Select2::widget([
                    'theme' => Select2::THEME_KRAJEE_BS4,
                    'name' => 'OylikUderj[oylik_hodimlar_id]',
                    'data' => OylikHodimlar::getAll(),
                    'options' => [
                        'placeholder' => 'Ходимнинг фамилиясини киритинг...',
                        // 'onchange'=>'getHodimById(this)',
                        'id'=>'myhodimsearch'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
            ]);?>

        <div class="help-block"></div>
    </div>



    <?= $form->field($model, 'title')->dropDownList(OylikUderjTypes::getAllForFrom()) ?>

    <?= $form->field($model, 'summa')->textInput() ?>

    <?= $form->field($model, 'period')->textInput(['value'=>OylikPeriods::getActivePeriod(), 'readonly'=>true]) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
