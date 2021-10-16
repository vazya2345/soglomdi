<?php

use yii\helpers\Html;
use app\models\FilialQoldiq;
/* @var $this yii\web\View */
/* @var $model app\models\FilialQoldiq */

$this->title = 'Ходим хисобига пул юбориш';
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filial-qoldiq-sendmoney card">
	<div class="card-body">
<?php
    $filial_qoldiqs = FilialQoldiq::getListForSendMoney();
    $mybalance = FilialQoldiq::getMyBalance();

    echo Html::beginForm(['filial-qoldiq/sendmoneyact'], 'post', ['enctype' => 'multipart/form-data']);
    echo Html::label('Ходим хисобини танланг', 'filial_qoldiq_id', ['class' => 'label username']);
    echo Html::dropDownList('filial_qoldiq_id', '', $filial_qoldiqs, ['class'=>'form-control', 'id'=>'form_filial_qoldiq_id']);
    echo "<br><br>";

    echo Html::label('Юбориш суммасини киритинг', 'form_send_money_sum', ['class' => 'label form_send_money_sum']);
    echo " &nbsp; <span class='hint'>(Максимал сумма: ". number_format($mybalance) ." сўм)</span>";
    echo Html::input('number', 'send_money_sum', '', ['class' => 'form-control', 'id'=>'form_send_money_sum', 'max'=>$mybalance]);
    echo "<br>";

    echo Html::label('Юбориш усулини танланг', 'form_send_type', ['class' => 'label username']);
    echo Html::dropDownList('send_type', '', [1=>'Нақд',2=>'Пластик'], ['class'=>'form-control', 'id'=>'form_send_type']);
    echo "<br>";

    echo Html::label('Қўшимча маълумот', 'form_send_desc', ['class' => 'label username']);
    echo Html::textarea('send_desc', '', ['class'=>'form-control', 'id'=>'form_send_desc']);
    echo "<br>";


    echo Html::submitButton('Юбориш', ['class' => 'btn btn-primary']);
    echo Html::endForm();
?>

	</div>
</div>


<style type="text/css">
    
</style>