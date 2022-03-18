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
$client = Client::findOne($model->client_id);
$reg_id = $_GET['reg_id'];
$resmodel = Result::find()->where(['main_id'=>$reg_id])->andWhere(['is not','main_id',null])->one();
$name = $client->lname.' '.date("Y-m-d",strtotime($resmodel->create_date));
header('Content-disposition: inline; filename="' . $name . '.pdf"'); 




$this->title = 'Пациент: '.$client->lname.' '.$client->fname.' '.$client->mname;
$this->params['breadcrumbs'][] = $this->title;

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
                            <img src="./img/ilon.jpg" alt="" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-5 text-center my-auto font-weight-bold text-uppercase">
                        <h4>Министерство Здравоохранения Республики Узбекистан</h4>
                        <h4>"SOG’LOM TABASSUM" ЧП</h4>
                    </div>
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
                        <strong>Full name / Полное имя
                            : </strong>
                        <span><?=$client->lname.' '.$client->fname.' '.$client->mname;?></span>
                    </h5>
                </div>
                <div class="my-1">
                    <h5>
                        <strong>Birth date / Дата рождения
                            : </strong>
                        <span><?=$client->birthdate?></span>
                    </h5>
                </div>
                <div class="my-1">
                    <h5>
                        <strong>Sex / Пол
                            : </strong>
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
                        <strong>Analysis date / Дата сдачи анализа: </strong>
                        <span>
                            <?php
                                echo date("d-m-Y H:i", strtotime($resmodel->create_date. " -183 minutes"));
                                // $model->create_date
                            ?>
                        </span>
                    </h5>
                </div>
                                    <div class="my-1 d-flex align-items-baseline">
                        <h5 class="mr-2">
                            <strong>Test result and date / Результат и дата теста: </strong>
                        </h5>
                        <h4>
                            <span>
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
                            </span>
                            <strong>(<?=date("d-m-Y H:i", strtotime($resmodel->create_date))?>)</strong>
                        </h4>
                    </div>
                                <div class="row my-2">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div id="qrContainer" class="w-100"><?=$qr?></div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="mt-5 mx-auto text-center">
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























