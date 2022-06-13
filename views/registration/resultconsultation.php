<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\SGroups;
use app\models\SAnaliz;
use app\models\InpTypes;
use app\models\InpText;
use app\models\Users;
use app\modules\dori\models\DoriList;
use app\modules\dori\models\DoriMahali;
use app\modules\dori\models\DoriDavomiyligi;
use app\modules\dori\models\DoriQayvaqtda;

use app\modules\consultation\models\ConsultationTashhisList;
use app\modules\consultation\models\ConsultationAnnestezyList;
use app\modules\consultation\models\ConsultationOperationList;


use kartik\select2\Select2;
// $pokazs = SPokazatel::getPokazs($model->analiz_id);

$this->title = 'Натижа киритиш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['indexlab']];
$this->params['breadcrumbs'][] = $this->title;

$client_model = Client::findOne($model->client_id);
?>
<div class="registration-index card">
    <div class="card-body">
    <p>
        <?= Html::a('Мижоз маълумотларини ўзгартириш', ['client/update', 'id'=>$model->client_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Танланган маълумотларини ўзгартириш', ['reg-dopinfo/updatereg', 'reg_id'=>$model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Пробирка рақамини ўзгартириш', ['registration/updatelab', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Натижа', ['registration/resultconsultationpdf', 'id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'other',
            'client_id'=>[
                'attribute'=>'client_id',
                'value' => function ($data) {
                        return Client::getName($data->client_id);                    
                }
            ],
            'create_date',
            'user_id'=>[
                'attribute'=>'user_id',
                'value' => function ($data) {
                        return Users::getNameAndFil($data->user_id);                    
                }
            ],
            'lab_vaqt',
        ],
    ]) ?>
    </div>
</div>

<div class="client-index card">
    <div class="card-body">
    <?= DetailView::widget([
        'model' => $client_model,
        'attributes' => [
            'doc_seria',
            'doc_number',
            'fname',
            'lname',
            'mname',
            'birthdate',
            'sex',
            'add1',
            'address_tuman',
            'address_text',
        ],
    ]) ?>
    </div>
</div>
<?= Html::beginForm(['/consultation/consultation-main/consultationsave', 'id' => $model->id], 'post', ['enctype' => 'multipart/form-data']) ?>


<!--  TASHHIS QO'YISH  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Ташхис танланг ёки киритинг</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <?php
                    $tashhislar = ConsultationTashhisList::find()->all();
                    foreach ($tashhislar as $key) {
                        echo '<div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="customCheckbox'.$key->id.'" alt="'.$key->title.'" name=consultation-tashhis['.$key->id.']>
                          <label for="customCheckbox'.$key->id.'" class="custom-control-label">'.$key->title.'</label>
                        </div>';
                    }
                ?>
            </div>
            <div class="col-6">
                <label>Бошқа ташхис киритиш</label>
                <?= Html::textarea('tashhis_custom', '', ['id' => 'consultation-yotoq-id', 'class' => 'form-control']) ?>
            </div>
        </div>
        
    </div>
</div>
<!--  TASHHIS QO'YISH  -->







<!--  DORI RECEPT  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Дори рецепт ёзиш</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row header">
            <div class="col-3">Дори номи</div>
            <div class="col-1">Доза</div>
            <div class="col-1">Шакли</div>
            <div class="col-2">Кабул килиш</div>
            <div class="col-1">Махали</div>
            <div class="col-1">Давомийлги (кун)</div>
            <div class="col-2">Қайси вақтда</div>
            <div class="col-1"></div>
        </div>
<?php
    for ($i=1; $i <= 20; $i++) {
        if($i>1){
            echo '<div id="dori-recept-oneblock-id'.$i.'" class="dori-recept-oneblock row hidden">';
        }
        else{
            echo '<div id="dori-recept-oneblock-id'.$i.'" class="dori-recept-oneblock row">';
        }
?>
        
            <div class="col-3">
                <?= Select2::widget([
                    'theme' => Select2::THEME_KRAJEE_BS4,
                    'name' => 'ConsultationDoriRecept['.$i.'][dori_title]',
                    'data' => DoriList::getAll(),
                    'maintainOrder' => true,
                    'options' => [
                        'placeholder' => 'Дорини киритинг...',
                        'id'=>'mydorisearch'.$i,
                        'onchange'=>'getDoriInfo(this,'.$i.')',

                    ],
                    'pluginOptions' => [
                    ],
                ]);?>
            </div>
            <div class="col-1">
                <?= Html::input('text', 'ConsultationDoriRecept['.$i.'][dori_doza]', '', ['id' => 'dori_doza_input_'.$i, 'class' => 'form-control', 'readonly'=>true]) ?>
            </div>
            <div class="col-1">
                <?= Html::input('text', 'ConsultationDoriRecept['.$i.'][dori_shakli]', '', ['id' => 'dori_shakli_input_'.$i, 'class' => 'form-control', 'readonly'=>true]) ?>
            </div>
            <div class="col-2">
                <?= Html::input('text', 'ConsultationDoriRecept['.$i.'][dori_qabul]', '', ['id' => 'dori_qabul_input_'.$i, 'class' => 'form-control', 'readonly'=>true]) ?>
            </div>
            <div class="col-1">
                <?= Html::input('number', 'ConsultationDoriRecept['.$i.'][dori_mahali]', '', ['id' => 'dori_mahali_input_'.$i, 'class' => 'form-control']) ?>
            </div>
            <div class="col-1">
                <?= Html::input('number', 'ConsultationDoriRecept['.$i.'][dori_davomiyligi]', '', ['id' => 'dori_davomiyligi_input_'.$i, 'class' => 'form-control']) ?>
            </div>

            <div class="col-2">
                <?= Html::dropDownList('ConsultationDoriRecept['.$i.'][dori_qayvaqtda]','', DoriQayvaqtda::getAll(), ['class'=>'form-control','prompt'=>'Танланг...']) ?>
            </div>
            <div class="col-1">
                <?= Html::button('+', ['id' => 'receptadd-button'.$i, 'class' => 'form-control btn btn-primary', 'onclick' => 'addReceptBlock('.$i.')']) ?>
            </div>
        </div>



<?php
    }
?>



        

    </div>
</div>
<!--  DORI RECEPT  -->


<!--  АНАЛИЗ  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Анализ турини танланг ёки киритинг</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <div class="row">
<?php
    $groups = SGroups::find()->where(['active'=>1])->orderBy(['ord'=>SORT_ASC])->all();
    foreach ($groups as $group) {
        echo '<div class="col-3">';
        echo   '<div class="card card-success" id="accordion'.$group->id.'">
                  <div class="card-header border-0">
                        <h4 class="card-title w-100">
                            <a class="d-block w-100" data-toggle="collapse" href="#collapse'.$group->id.'" aria-expanded="true">
                              '.$group->title.'
                            </a>
                        </h4>
                  </div>';
          
            echo '<div id="collapse'.$group->id.'" class="collapse show" data-parent="#accordion'.$group->id.'">';
          

          echo '
              <div class="card-body">
                <div>';

        $analizs = SAnaliz::find()->where(['group_id'=>$group->id,'is_active'=>1])->orderBy(['ord'=>SORT_ASC])->all();
        foreach ($analizs as $analiz) {
            echo '
                                                    <div class="custom-control custom-checkbox">
                                                      <input class="custom-control-input" type="checkbox"  id="customCheckboxanaliz'.$analiz->id.'" alt="'.$analiz->id.'" name=ConsultationAnalizs['.$analiz->id.']>
                                                      <label for="customCheckboxanaliz'.$analiz->id.'" class="custom-control-label">'.$analiz->title.'</label>
                                                    </div>
                                            ';
        }

        echo '                  </div>
                                  </div>
                              </div>
                            </div>
                            </div>
                    
                ';
    }



?>
                <?php /* Select2::widget([
                    // 'theme' => Select2::THEME_KRAJEE_BS4,
                    'name' => 'ConsultationAnalizs',
                    'data' => SAnaliz::getAll(),
                    // 'maintainOrder' => true,
                    'options' => [
                        'placeholder' => 'Анализларни танланг...',
                        'id'=>'myanalizsearch',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                    ],
                ]); */

                ?>
            </div>
        </div>
            <div class="col-12">
                <?= Html::textarea('analiz_custom', '', ['id' => 'consultation-analiz-id', 'class' => 'form-control','placeholder' => 'Бошқа анализ турини киритинг...',]) ?>
            </div>
        </div>
        
    </div>
</div>
<!--  АНАЛИЗ  -->




<!--  YOTOQ  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Ётоқ ёзиш</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                Неча кун стационар даволаниш кераклигини киритинг
            </div>
            <div class="col-6">
                <?= Html::input('number', 'cosultation-yotoq', '', ['id' => 'consultation-yotoq-id', 'class' => 'form-control']) ?>
            </div>
        </div>
        
    </div>
</div>
<!--  YOTOQ  -->




<!--  OPERATSIYA  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Операция турини танланг ёки киритинг</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <?php
                    $operations = ConsultationOperationList::find()->all();
                    foreach ($operations as $key) {
                        echo '<div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="customCheckboxOper'.$key->id.'" alt="'.$key->title.'" name=consultation-operations['.$key->id.']>
                          <label for="customCheckboxOper'.$key->id.'" class="custom-control-label">'.$key->title.'</label>
                        </div>';
                    }
                ?>
            </div>
            <div class="col-6">
                <label>Бошқа операция турини киритиш</label>
                <?= Html::textarea('operatsiya_custom', '', ['id' => 'consultation-operation-id', 'class' => 'form-control']) ?>
            </div>
        </div>
        
    </div>
</div>
<!--  OPERATSIYA  -->

<!--  ANESTEZIYA  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Анестезия турини танланг ёки киритинг</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <?php
                    $anstezies = ConsultationAnnestezyList::find()->all();
                    foreach ($anstezies as $key) {
                        echo '<div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" id="customCheckboxAnestezy'.$key->id.'" alt="'.$key->title.'" name=consultation-anestezy['.$key->id.']>
                          <label for="customCheckboxAnestezy'.$key->id.'" class="custom-control-label">'.$key->title.'</label>
                        </div>';
                    }
                ?>
            </div>
            <div class="col-6">
                <label>Бошқа анестезия турини киритиш</label>
                <?= Html::textarea('anestezy_custom', '', ['id' => 'consultation-anestezy-id', 'class' => 'form-control']) ?>
            </div>
        </div>
        
    </div>
</div>
<!--  ANESTEZIYA  -->



<!--  BOSHQA GAPLAR  -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Бошқа изохлар</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?= Html::textarea('custom-text-consultation', '', ['id' => 'consultation-text-id', 'class' => 'form-control']) ?>
            </div>
        </div>
        
    </div>
</div>
<!--  BOSHQA GAPLAR  -->





<div class="client-index card">
    <div class="card-body">
    <?= Html::submitButton('Якунлаш', ['class' => 'btn btn-primary float-right','data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ],]) ?>
    <?= Html::endForm() ?>
    </div>
</div>


<style type="text/css">
    #results div.grid-view div.summary{
        display: none;
    }
    #results div.grid-view table thead{
        display: none;
    }
    #results div.grid-view table tbody td:nth-child(1){
        width: 5%;
    }
    #results div.grid-view table tbody td:nth-child(2){
        width: 75%;
    }
    .header div{
        text-align: center;
        font-weight: bold;
    }
    .dori-recept-oneblock{
        margin-bottom: 10px;
    }
    .hidden{
        display: none;
    }
</style>


<script type="text/javascript">
    function getDoriInfo(elem, id){

        if(elem.value>0){
            $.ajax({
                url: '?r=dori/dori-list/getdoribyid',         /* Куда пойдет запрос */
                method: 'get',             /* Метод передачи (post или get) */
                dataType: 'json',          /* Тип данных в ответе (xml, json, script, html). */
                data: {id: elem.value},     /* Параметры передаваемые в запросе. */
                success: function(data){   /* функция которая будет выполнена после успешного запроса.  */
                    $("#dori_doza_input_"+id).val(data.doza);
                    $("#dori_shakli_input_"+id).val(data.shakli);
                    $("#dori_qabul_input_"+id).val(data.qabul);
                }
            });
        }


        
    }

    function addReceptBlock(id){
        id2=id+1;
        $("#dori-recept-oneblock-id"+id2).removeClass('hidden');
        $("#receptadd-button"+id).addClass('hidden');
        
    }

</script>