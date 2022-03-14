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
    'size' => 6,
]);
$qr = str_replace('/web', './', $qr);
?>

<div class="content px-2">
    <div class="row">
        <div class="col-12">
            <div class="card border-flag pt-2 px-2 pb-1 pt-lg-5 px-lg-5 pb-lg-2">
                


                <div class="row mb-5">
                    <div class="col-md-5 text-center my-auto font-weight-bold text-uppercase">
                        <h4>Ministry of Health of the Republic of Uzbekistan</h4>
                        <h4>«SOG’LOM TABASSUM» ХК</h4>
                    </div>
                    <div class="col-md-2">
                        <div class="mx-auto">
                            <img src="./img/ilon.jpg" alt="" class="w-100 logo" width="100">
                        </div>
                    </div>
                    <div class="col-md-5 text-center my-auto font-weight-bold text-uppercase">
                        <h4>Министерство Здравоохранения Республики Узбекистан</h4>
                        <h4>"SOG’LOM TABASSUM" ЧП</h4>
                    </div>
                    <div class="clear"></div>
                </div>



                <div class="my-1">
                    <h5>
                        <strong>ID / Номер: </strong>
                        <span><?=$_GET['reg_id']?></span>
                    </h5>
                </div>
                <div class="my-1">
                    <h5>
                        <strong>Laboratory (name) / Лаборатория (название):
                        </strong>
                        <span>"SOG’LOM TABASSUM" ЧП</span>
                    </h5>
                </div>
                <div class="my-1">
                    <h5>
                        <strong>Place of sampling / Место забора анализа
                            : </strong>
                        <span>"SOG’LOM TABASSUM" ЧП</span>
                    </h5>
                </div>
                <div class="my-1">
                    <h5>
                        <strong>Research method / Метод исследования: </strong>
                        <span>
                            <?php
                                if($group=='ЭКСПРЕСС ТЕСТ ДИАГНОСТИКА'){
                                    echo 'PCR Real-time / ПЦР в реальном времени';
                                }
                                elseif($group=='КОВИД1'){
                                    echo 'SARS-CoV-2 (ПЦР мазок)';
                                }
                                else{
                                    echo 'PCR Real-time / ПЦР в реальном времени';
                                }
                            ?>
                        </span>
                    </h5>
                </div>


                

                <hr style="border: 4px solid #bbb">
                


                <div class="my-1">
                    <h5>
                        <strong>Passport / Серия и номер паспорта: </strong>
                        <span><?=$client->doc_seria.$client->doc_number?></span>
                    </h5>
                </div>

                <div class="my-1">
                    <h5>
                        <strong>Full name / Полное имя: </strong>
                        <span><?=$client->lname.' '.$client->fname.' '.$client->mname;?></span>
                    </h5>
                </div>

                <div class="my-1">
                    <h5>
                        <strong>Birth date / Дата рождения: </strong>
                        <span><?=$client->birthdate?></span>
                    </h5>
                </div>

                <div class="my-1">
                    <h5>
                        <strong>Sex / Пол: </strong>
                        <span>
                            <?php
                                if($client->sex=='M'){
                                    echo "Male / Мужчина";
                                }
                                else{
                                    echo "Female / Женщина";
                                }
                            ?>
                        </span>
                    </h5>
                </div>

                <div class="my-1">
                    <h5>
                        <strong>Analysis date / Дата сдачи анализа:</strong>
                        <span><?=$model->create_date?></span>
                    </h5>
                </div>
                

                <div class="my-1 d-flex align-items-baseline">
                        <h5 class="mr-2">
                            <strong>Test result and date / Результат и дата теста: </strong>
                            <?php
                                if($resmodel->reslut_value=='Положительный'){
                                    echo '<span>Positive / Положительный</span>';
                                }
                                elseif($resmodel->reslut_value=='Отрицательный'){
                                    echo '<span>Negative / Отрицательный</span>';
                                }
                                else{
                                    echo 'Natija kiritilmagan';
                                }
                            ?>
                            
                            
                            <strong>(<?=$resmodel->create_date?>)</strong>
                        </h5>
                </div>
                





                <div class="row my-2">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div id="qrContainer" class="w-100"><?=$qr?></div>
                    </div>
                    <div class="col-md-4"></div>
                </div>





                <div class="mt-5 mx-auto text-center myfooter">
                    <h6 class="text-uppercase">
                        <span>«SOG’LOM TABASSUM» ХК</span>
                    </h6>
                    <h6>
                        <span>Адрес: </span>
                        <span>Андижон ш., Бобур шох кўчаси 109-Б уй.</span>
                    </h6>
                    <h6>
                        <span>Телефон: </span>
                        <a href="tel:998952040150">+998 95 204-01-50</a>
                    </h6>
                    <h6>
                        <span>Email: </span>
                        <a href="mailto:info@soglom-diagnostika.uz">
                            info@soglom-diagnostika.uz
                        </a>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>





























<style type="text/css">
    .cont {
        width: 1050px!important;
    }
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





/*new style*/

div{
    font-family: Nunito;
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 0;
    
}
.border-flag {
    border: 40px solid transparent;
    -o-border-image: url('./img/flag_border.png') 12% stretch;
    border-image: url('./img/flag_border.png') 12% stretch;
}
.h4{
    text-transform: uppercase!important;
}
.col-md-5{
    max-width: 38%;
    float: left;
    padding: 20px;
}
.col-md-2{
    max-width: 13%;
    float: left;
}
.clear{
    clear: both;
}
h4{
    font-size: 18px;
    text-align: center;
    font-weight: normal;
}
div img.logo{
    vertical-align: middle;
    padding: 45% 0 0px 0;
}
.my-1{
    margin-bottom: 15px!important;
    margin-top: 15px!important;
    margin-left: 25px;
    text-transform: none;
}
.my-1 h5{
    font-size: 1.125rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 0;
}
#qrContainer{
    text-align: center;
    padding: 25px 0;
}
.text-uppercase{
    text-transform: uppercase;
}
.text-center{
    text-align: center;
}
.myfooter{
    font-size: 26px;
    font-weight: normal;

}
.myfooter h6{
    margin: 10px 0;
    padding: 0;
    font-weight: normal;
}
</style>

