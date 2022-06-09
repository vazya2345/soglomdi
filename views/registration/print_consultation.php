<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Client;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;

use app\modules\consultation\models\ConsultationDoriRecept;
use app\modules\consultation\models\ConsultationMain;

$this->title = 'Натижа';
$this->params['breadcrumbs'][] = $this->title;
$client_name = Client::getName($model->client_id);
$res_date = date('Y-m-d H:i:s');
$name = $client_name.' '.date("Y-m-d",strtotime($res_date));
header('Content-disposition: inline; filename="' . $name . '.pdf"'); 


?>

<div class="header">
    <table class="tb-header">
        <tr>
            <td align="center">
                <img src="./img/sms-clinica.png" class="logo" width="250">
            </td>
            <td>
<?php 

$qr = Text::widget([
    'outputDir' => '@webroot/upload/qrcode',
    'outputDirWeb' => '@web/upload/qrcode',
    'ecLevel' => QRcode::QR_ECLEVEL_L,
    'text' => Url::home('http').'?r=registration%2Fviewqr&group=tashhis&reg_id='.$_GET['reg_id'],
    'size' => 2,
]);
$qr = str_replace('/web', './', $qr);
echo $qr;
?>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center" class="adress">
                «SOG’LOM TABASSUM» ХК, манзил Андижон ш., Бобур шох кўчаси 109-Б уй. Тел:(0-595) 204-01-50.
            </td>

        </tr>
    </table>

</div>

<div class="container">
    


<div class="content-top-table-div">
     <table class="table_client">
        <tr>
            <td class="bold">Пациент: <?=$client_name?></td>
            <td class="bold" rowspan="2" valign="top">Дата: <?=$res_date?></td>
            <td class="bold">Дата рождения: <?=Client::getBirthDate($model->client_id)?></td>
        </tr>
    </table>
    <table class="table_analiz">
        <tr>
            <td class="name-of-analiz" colspan="3">
                Консультация
            </td>
        </tr>
    </table>
</div>




<div class="analiz-results">
    <div class="row">
        <div class="col-6 firstcol">
<?php
    $tashhislar = ConsultationMain::find()->where(['reg_id'=>$model->id, 'consultation_type'=>'Ташхис'])->all();
    $i=1;
    foreach ($tashhislar as $tashhis) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=2>Ташхислар</th></tr>";
        }
        echo "<tr><td colspan=2>".$tashhis->value."</td></tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>
        </div>
        <div class="col-6">
<?php
    $analizlar = ConsultationMain::find()->where(['reg_id'=>$model->id, 'consultation_type'=>'Анализ'])->all();
    $i=1;
    foreach ($analizlar as $analiz) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=2>Анализлар</th></tr>";
        }
        echo "<tr><td colspan=2>".$analiz->value."</td></tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>


        </div>
        <div class="clear"></div>
</div>

<?php
    $receptlar = ConsultationDoriRecept::find()->where(['reg_id'=>$model->id])->all();
    $i=1;
    foreach ($receptlar as $recept) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=7>Рецепт</th></tr>";
            echo '<tr>';
            echo '<th>Дори номи</th>';
            echo '<th>Доза</th>';
            echo '<th>Шакли</th>';
            echo '<th>Қабул килиш</th>';
            echo '<th>Махали</th>';
            echo '<th>Давомийлги (кун)</th>';
            echo '<th>Қайси вақтда</th>';
            echo '</tr>';
        }
        echo "<tr>";
        echo "<td>".$recept->dori_title."</td>";
        echo "<td>".$recept->dori_doza."</td>";
        echo "<td>".$recept->dori_shakli."</td>";
        echo "<td>".$recept->dori_mahali." махал</td>";
        echo "<td>".$recept->dori_davomiyligi." кун</td>";
        echo "<td>".$recept->dori_qabul."</td>";
        echo "<td>".$recept->dori_qayvaqtda."</td>";
        echo "</tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>

<?php
    $yotoqlar = ConsultationMain::find()->where(['reg_id'=>$model->id, 'consultation_type'=>'Ётоқ'])->all();
    $i=1;
    foreach ($yotoqlar as $yotoq) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=2>Стационар даволаниш (ётоқ)</th></tr>";
        }
        echo "<tr><td colspan=2>".$yotoq->value." кун</td></tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>


<div class="row">
    <div class="col-6 firstcol">
<?php
    $operaciyalar = ConsultationMain::find()->where(['reg_id'=>$model->id, 'consultation_type'=>'Операция'])->all();
    $i=1;
    foreach ($operaciyalar as $operaciya) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=2>Операциялар</th></tr>";
        }
        echo "<tr><td colspan=2>".$operaciya->value."</td></tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>
    </div>
    <div class="col-6">
<?php
    $anasteziyalar = ConsultationMain::find()->where(['reg_id'=>$model->id, 'consultation_type'=>'Анестезия'])->all();
    $i=1;
    foreach ($anasteziyalar as $anesteziya) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=2>Анестезия</th></tr>";
        }
        echo "<tr><td colspan=2>".$anesteziya->value."</td></tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>
    </div>
    <div class="clear"></div>
</div>

<?php
    $boshqa_izohlar = ConsultationMain::find()->where(['reg_id'=>$model->id, 'consultation_type'=>'Бошқа изохлар'])->all();
    $i=1;
    foreach ($boshqa_izohlar as $boshqa_izoh) {
        if($i==1){
            echo "<table class='table'><tr><th colspan=2>Бошқа изохлар</th></tr>";
        }
        echo "<tr><td colspan=2>".$boshqa_izoh->value."</td></tr>";
        $i++;
    }
    if($i!=1){
        echo "</table>";
    }
?>


</div>

</div>

<style type="text/css">
    @page *{
        margin-top: 0cm;
        margin-bottom: 0cm;
        margin-left: 0cm;
        margin-right: 0cm;
    }
    body{
        margin: 0;
    }

    .content-top-table-div table{
        width: 100%;
    }
    .bold{
        font-weight: bold;
    }
    .summary{
        display: none;
    }

    table.table{
        border-spacing: 0;
        width: 100%;
        margin-bottom: 10px;
    }
    table.table td{
        text-align: left;
    }
    table.table td, table.table th{
        border: 1px solid black;
        padding: 5px;
        font-size: 10px;
    }
    table.table td:nth-child(1){
        width: 25%;
        text-align: left;
        font-weight: bold;
    }

    .bg-danger{
        background-color: #FF808099;
    }
    .bg-success{
        background-color: #61E35D99;
    }

    table.table th{
        background-color: silver;
        padding: 5px 10px;
        font-size: 10px;
    }
    .table_analiz, .table_client{
        margin-top: 2px;
    }
    .analiz-results{
        margin-top: 10px;
    }
    .name-of-analiz{
        font-size: 10px;
        font-weight: bold;
        color: gray;
        text-align: center;
    }


.table_client{
    font-size: 10px;
}
.adress{
    font-size: 10px;
    text-align: center;
    padding-left: 50px;
}
.tb-header{
    margin: 0 auto;
}
.col-6{
    width: 48%;
    display: inline-block;
    float: left;
}
.firstcol{
    padding-right: 26px;
}
.clear{
    clear: both;
}
</style>





