<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use app\models\Client;
use app\models\SPokazatel;
use app\models\PokazLimits;
use app\models\SAnaliz;
use app\models\Result;
use app\models\Users;
use xj\qrcode\QRcode;
use xj\qrcode\widgets\Text;

$pokazs = SPokazatel::getPokazs($analiz_id);
// var_dump($model);die;
$this->title = 'Натижа';
$this->params['breadcrumbs'][] = $this->title;
$client = Client::findOne($model->client_id);
$reg_id = $_GET['reg_id'];
$resmodel = Result::find()->where(['main_id'=>$reg_id])->andWhere(['is not','main_id',null])->one();
// var_dump($resmodel);die;
$name = $client->lname.' '.date("Y-m-d",strtotime($resmodel->create_date));
header('Content-disposition: inline; filename="' . $name . '.pdf"'); 

?>

<?php 

$qr = Text::widget([
    'outputDir' => '@webroot/upload/qrcode',
    'outputDirWeb' => '@web/upload/qrcode',
    'ecLevel' => QRcode::QR_ECLEVEL_L,
    'text' => 'https://soglom-diagnostika.uz/?r=registration%2Fviewqr&group='.$group.'&reg_id='.$_GET['reg_id'],
    'size' => 3,
]);
$qr = str_replace('/web', './', $qr);
?>

<div class="header">
    <table class="tb-header">
        <tr>
            <td align="center" colspan="2">
                <img src="./img/st.jpg" class="logo" width="300">
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                «SOG’LOM TABASSUM» ХК, манзил Андижон ш., Бобур шох кўчаси 109-Б уй. Тел:(0-595) 204-01-50.
            </td>

        </tr>
    </table>

</div>

<div class="header">

    <div class="top_title">
        <p class="top_title_text blue fnt_big fnt_curved">The test results about coronavirus (Covid19) infection</p>
        <p class="top_title_text red fnt_big">REFERENCE*</p>
        <p class="top_title_text blue fnt_big fnt_curved">Коронавирус (Covid 19) инфекциясига текширилган<br>тест натижаси ҳақида</p>
        <p class="top_title_text red fnt_big">МАЪЛУМОТНОМА* №<?=$_GET['reg_id']?></p>
        <p class="top_title_text blue fnt_big fnt_curved">о результате проводимого теста<br>на коронавирусную (Covid 19) инфекцию</p>
        <p class="top_title_text red fnt_big">СПРАВКА*</p>
    </div>

</div>

<div class="container">
    <div class="content-top-table-div">
         <table class="table_client">
            <tr>
                <td>1.</td>
                <td>Full name<br>Фамилия, исм, шариф<br>Фамилия, имя, отечество</td>
                <td class="text_bottom"><?=$client->lname.' '.$client->fname.' '.$client->mname;?></td>
                <td rowspan="7"><img class="covid_img" src="./img/covid.jpg"></td> 
            </tr>
            <tr>
                <td>2.</td>
                <td>Date of birth<br>Туғилган санаси<br>Дата рождения</td>
                <td class="text_bottom"><?=$client->birthdate?></td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Passport series and number<br>Паспорт серияси ва рақами<br>Серия и номер паспорта</td>
                <td class="text_bottom"><?=$client->doc_seria.$client->doc_number?></td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Phone number<br>Телефон рақами<br>Номер телефона</td>
                <td class="text_bottom">
                    <?php
                        if($client->add1=='+998000000000'){
                            echo '';
                        }
                        else{
                            echo $client->add1;
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>5.</td>
                <td>Date tested<br>Текширилган сана<br>Дата тестирования</td>
                <td class="text_bottom"><?=$resmodel->create_date?></td>
            </tr>
            <tr>
                <td>6.</td>
                <td>Research method<br>Текширув усули<br>Метод исследования</td>
                <?php
                    if($group=='ЭКСПРЕСС ТЕСТ ДИАГНОСТИКА'){
                        echo '<td class="text_bottom">SARS-CoV-2 (ПЦР мазок)</td>';
                    }
                    else{
                        echo '<td class="text_bottom">PCR Real-time<br>PZR<br>ПЦР в реальном времени</td>';
                    }
                ?>
                
            </tr>
            <tr>
                <td>7.</td>
                <td>The result of laboratory analysis<br>Лаборатор таҳлил натижаси<br>Результат лабораторного анализа</td>
                <td class="text_bottom">
                    <?php
                        if($resmodel->reslut_value=='Положительный'){
                            echo 'Positive<br>Положительный<br>Musbat';
                        }
                        elseif($resmodel->reslut_value=='Отрицательный'){
                            echo 'Negative<br>Отрицательный<br>Manfiy';
                        }
                        else{
                            echo 'Natija kiritilmagan';
                        }
                    ?>
                </td>
            </tr>
        </table>
        
    </div>
    <div>
        <table class="table_client1">
            <tr>
                <td>The person responsible for analysis</td>
                <td></td>
            </tr>
            <tr>
                <td>Тахлил учун маъсул шахс</td>
                <td><?=Users::getName($model->user_id)?>  _______________ «<?=date('d')?>» <?=date('m')?> <?=date('Y')?></td>
            </tr>
            <tr>
                <td>Ответственное лицо за анализ</td>
                <td class="imzo">(имзо/подпись/signature)</td>
            </tr>
        </table>
    </div>
    <!-- <span>м.ў/м.п</span> -->
    
  <br>
    
                             
<div class="qrimg">
    <?=$qr?>
    <p class="qrtext"><br>Checking the result<br>Проверка результатов<br>Natijani tekshirish</p>
</div>

</div>

<style type="text/css">
    .content-top-table-div table{
        width: 100%;
    }
    .bold{
        font-weight: bold;
    }

.blue{
    color: #0677bf;
    padding: 0;
    margin: 0;
}
.red{
    color: red;
    padding: 0;
    margin: 0;
}
.fnt_big{
    font-size: 16px;
}
.fnt_curved{
    font-style: italic;
}
.top_title_text{
    text-align: center;
}
.table_client, .table_client1{
    font-size: 14px;
}
.table_client tr td:nth-child(2){
    width: 200px;
}
.table_client tr td:nth-child(1){
    vertical-align: top;
}
.table_client1 tr td:nth-child(1){
    width: 250px;
}
.table_client1{
    width: 100%;
}
.text_bottom{
    vertical-align: middle;
    padding-left: 50px;
    text-align: center;
}
.eslatma{
    text-align: right;
    font-size: 14px;
}
.covid_img{
    width: 100px;
    height: 60%;
    text-align: right;
}
.qrimg{
    text-align: center;
}
.qrtext{
    text-align: center;
    padding: 0;
    margin: 0;
}
.imzo{
    font-size: 10px;
    /*text-align: center;*/
    vertical-align: top;
    padding-left: 120px;
}
</style>

