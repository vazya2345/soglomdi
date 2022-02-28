<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\services\ExportService;
use app\entities\ExportEntity;
use app\models\Registration;
use app\models\Client;
use app\models\Result;
use app\models\Users;
use app\models\Referals;
use app\models\Filials;
use app\models\RegAnalizs;
use app\models\SAnaliz;
use app\models\SPokazatel;
use app\models\RegDopinfo;
use app\models\PokazLimits;
use app\models\MoneySend;
use app\models\Payments;
use app\models\FqSends;
use app\models\Rasxod;
use app\models\FilialQoldiq;

use app\models\Reagent;
use app\models\ReagentFilial;
use app\models\SRasxodTypes;
use app\models\RefSends;
use yii\helpers\ArrayHelper;



class ReportController extends Controller
{
    protected $_service;

    public function __construct($id, $module, ExportService $service,$config = []) {
        $this->_service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(10 * 60);

        $header = [
            "№",
            "Бемор ФИО",
            "Регистратор",
            "Бемор Телефон",
            "Регистрация санаси",
            "Лаборатор текширув санаси",
            "Туланмаган кунлар",
            "Скидка сумма",
            "Туланган",
            "Карз",
            "Реферал коди",
            "Шифохона номи",
            "Реферал ФИО",
            "Реферал тел раками",
        ];

        $body = [];

        $mains = Registration::find()
            ->where(['>', 'sum_debt', 0])
            //->AndWhere(['<>', 'type', 1])
            ->all();


        Yii::$app->response->format = 'json';
        $n = 1;
        foreach($mains as $main) {

            $body[] = [
                $n,

                Client::getName($main->client_id),

                Users::getNameAndFil($main->user_id),

                Client::getPhonenum($main->client_id),

                date("d.m.Y", strtotime($main->create_date)),

                Result::getMaxDate($main->id),
                
                round((strtotime($main->create_date)-time())/(24*60*60)),

                ($main->skidka_kassa+$main->skidka_reg),

                ($main->sum_plastik+$main->sum_cash),
                
                empty($main->sum_debt)                         ? 0     : $main->sum_debt,
                
                empty($main->ref_code)                         ? '-'     : Referals::getHospital($main->ref_code),

                empty($main->ref_code)                         ? '-'     : Referals::getName($main->ref_code),

                empty($main->ref_code)                         ? '-'     : Referals::getPhone($main->ref_code),
            ];

            $n++;
        }

        $exportEntity = new ExportEntity($header, $body);

        return $this->_service->exec($exportEntity);
    }


    public function actionReferals1()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(10 * 60);

        $header = [
            '№',
            'ФИО бемор',
            'Бемор тел раками',
            'Регистрация санаси',
            'Топширилган анализлар',
            'Анализ нархлари',
            'Анализ суммаси',
            'Скидка',
            'Анализ суммаси скидкадан кейин',
            'Реферал коди',
            'Шифохона номи',
            'Реферал ФИО',
            'Реферал тел раками',
            'Фоизи',
            'Аванс колдиги',
            'Хисобланган фоиз',
            'Хисоблаш (саналар буйича)',
            'Юбориш',
            'Масул шахс ФИО',
        ];

        $body = [];

        $mains = Registration::find()
            ->where(['!=','ref_code',''])
            ->orderBy(['ref_code' => SORT_ASC])
            ->all();


        Yii::$app->response->format = 'json';
        $n=1;
        foreach($mains as $main) {
            $referal = Referals::getByRefnum($main->ref_code);

            $body[] = [
                $n++,

                Client::getName($main->client_id),

                Client::getPhonenum($main->client_id),

                date("d.m.Y", strtotime($main->create_date)),

                RegAnalizs::getAnalizsNamesByRegId($main->id),

                RegAnalizs::getAnalizsCostsByRegId($main->id),

                $main->sum_amount,

                ($main->skidka_reg+$main->skidka_kassa),

                ($main->sum_amount-$main->skidka_reg-$main->skidka_kassa),

                $main->ref_code,

                $referal->desc,

                $referal->fio,

                $referal->phone,

                $referal->add1,

                $referal->avans_sum,

                (($main->sum_amount-$main->skidka_reg-$main->skidka_kassa)*(int)$referal->add1/100),

                '',

                '',

                '',


            ];
        }

        $exportEntity = new ExportEntity($header, $body);

        return $this->_service->exec($exportEntity);
    }

    public function actionDoktor1prev()
    {
    	if(Yii::$app->request->post('date1')){
    		if(strlen(Yii::$app->request->post('date1'))==0){
    			$date1 = date("Y-m-d");
    		}
    		else{
    			$date1 = Yii::$app->request->post('date1');
    		}

    		if(strlen(Yii::$app->request->post('date2'))==0){
    			$date2 = date("Y-m-d");
    		}
    		else{
    			$date2 = Yii::$app->request->post('date2');
    		}

    		if(strlen(Yii::$app->request->post('filial'))==0){
    			$filial = 'all';
    		}
    		else{
    			$filial = Yii::$app->request->post('filial');
    		}

            if(strlen(Yii::$app->request->post('analiz'))==0){
                $analiz = 'all';
            }
            else{
                $analiz = Yii::$app->request->post('analiz');
            }

    		if(strlen(Yii::$app->request->post('referal'))==0){
    			$referal = 'all';
    		}
    		else{
    			$referal = Yii::$app->request->post('referal');
    		}
    		$this->doktor1Report($date1,$date2,$filial,$referal,$analiz);
    	}
    	return $this->render('doktor1');
    }

    private function doktor1Report($date1,$date2,$filial,$referal,$analiz)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/doktor1.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('C2', $date1, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('D2', $date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('F2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('H2', $referal, \PHPExcel_Cell_DataType::TYPE_STRING);

        $models = Registration::find()->where(['between','create_date',$date1,$date2]);
        if($filial!='all'){
        	$models->andWhere(['in','user_id',Users::getFilUsers($filial)]);
        }
        if($referal!='all'){
        	$models->andWhere(['ref_code'=>$referal]);
        }
        if($analiz!='all'){
            $models->andWhere(['in','id',RegAnalizs::getRegIds($analiz)]);
        }
        $res = $models->orderBy(['id'=>SORT_ASC, 'ref_code' => SORT_ASC])->all();
        // var_dump($res);die;
  		$row = 5;
  		$bb=1;

        foreach ($res as $reg) {
        	$activeSheet->setCellValueExplicit('A'.$row, $bb++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('B'.$row, $reg->other, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('C'.$row, Client::getName($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('D'.$row, Client::getPhonenum($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('E'.$row, date("d.m.Y", strtotime($reg->create_date)), \PHPExcel_Cell_DataType::TYPE_STRING);
            // var_dump($analiz);die;
            if($analiz!='all'){
                $analizs = RegAnalizs::find()->where(['reg_id'=>$reg->id, 'analiz_id'=>$analiz])->all();
            }
            else{
                $analizs = RegAnalizs::find()->where(['reg_id'=>$reg->id])->all();
            }

        	$na = 0;
        	foreach ($analizs as $key) {
        		$ra = $row+$na;
        		$activeSheet->setCellValueExplicit('F'.$ra, SAnaliz::getName($key->analiz_id), \PHPExcel_Cell_DataType::TYPE_STRING);
        		$activeSheet->setCellValueExplicit('G'.$ra, $key->summa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        		$na++;
        	}
        	$activeSheet->setCellValueExplicit('H'.$row, $reg->sum_amount, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        	$activeSheet->setCellValueExplicit('I'.$row, $reg->skidka_reg+$reg->skidka_kassa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        	$activeSheet->setCellValueExplicit('J'.$row, $reg->sum_amount-($reg->skidka_reg+$reg->skidka_kassa), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            if($reg->sum_cash>0){
                $k_str = 'Нақд';
            }
            else{
                if($reg->sum_plastik>0){
                    $k_str = 'Пластик';    
                }
                else{
                    $k_str = 'Хабар';
                }   
            }
            $activeSheet->setCellValueExplicit('K'.$row, $k_str, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('L'.$row, $reg->sum_cash+$reg->sum_plastik, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $activeSheet->setCellValueExplicit('M'.$row, $reg->sum_amount-($reg->skidka_reg+$reg->skidka_kassa+$reg->sum_cash+$reg->sum_plastik), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        	$activeSheet->setCellValueExplicit('N'.$row, Users::getNameAndFil($reg->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('O'.$row, $reg->ref_code, \PHPExcel_Cell_DataType::TYPE_STRING);

        	$referal = Referals::getByRefnum($reg->ref_code);
        	$activeSheet->setCellValueExplicit('P'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('Q'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('R'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('S'.$row, $referal->add1, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('T'.$row, $referal->avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        	$foiz = (int)$referal->add1;
            if($reg->sum_amount==($reg->sum_cash+$reg->sum_plastik)){
                if($foiz>0){
                    $activeSheet->setCellValueExplicit('U'.$row, ($reg->sum_amount-($reg->skidka_reg+$skidka_kassa))*$foiz/100, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                }
                else{
                    $activeSheet->setCellValueExplicit('V'.$row, $referal->fix_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                }
                    
            }
        	




            if($na==0){
                $na=1;
            }
    		$row=$row+$na;
            // $n++;
        }
        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="doktor1_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    public function actionQarzreportprev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }

            if(strlen(Yii::$app->request->post('analiz'))==0){
                $analiz = 'all';
            }
            else{
                $analiz = Yii::$app->request->post('analiz');
            }

            if(strlen(Yii::$app->request->post('referal'))==0){
                $referal = 'all';
            }
            else{
                $referal = Yii::$app->request->post('referal');
            }

            $kunlar = Yii::$app->request->post('kunlar');
            $this->qarzReport($date1,$date2,$filial,$referal,$analiz,$kunlar);
        }
        return $this->render('qarz');
    }

    private function qarzReport($date1,$date2,$filial,$referal,$analiz,$kunlar)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/qarzdor.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('E1', $date1, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('F1', $date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('G1', $filial, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('H1', $referal, \PHPExcel_Cell_DataType::TYPE_STRING);
        // $date

        $models = Registration::find()->where(['between','create_date',$date1,$date2])->andWhere(['>','sum_debt',0]);
        // var_dump($models);die;
        if($filial!='all'){
            $models->andWhere(['in','user_id',Users::getFilUsers($filial)]);
        }
        if($referal!='all'){
            $models->andWhere(['ref_code'=>$referal]);
        }
        if($analiz!='all'){
            $models->andWhere(['in','id',RegAnalizs::getRegIds($analiz)]);
        }
        $res = $models->orderBy(['ref_code' => SORT_ASC])->all();


        $status_arr = [1=>'Янги',2=>'Р/Э амалиётда',3=>'Амалиётда',4=>'Якунланди'];
        // var_dump($res);die;
        $row = 3;
        $n=1;
        foreach ($res as $reg) {
            if((round((time()-strtotime($reg->create_date))/60/60/24)>$kunlar)||($kunlar==0)){
                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, Client::getName($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('C'.$row, Filials::getName(Users::getFilial($reg->user_id)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('D'.$row, Users::getNameAndFil($reg->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('E'.$row, Client::getPhonenum($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('F'.$row, date("d.m.Y", strtotime($reg->create_date)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('G'.$row, Result::getMaxDate($reg->id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('H'.$row, $status_arr[$reg->status], \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('I'.$row, round((time()-strtotime($reg->create_date))/60/60/24), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('J'.$row, $reg->sum_amount, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('K'.$row, $reg->skidka_reg+$skidka_kassa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('L'.$row, $reg->sum_cash+$reg->sum_plastik, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('M'.$row, $reg->sum_debt, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('N'.$row, $reg->ref_code, \PHPExcel_Cell_DataType::TYPE_STRING);
                $referal = Referals::getByRefnum($reg->ref_code);
                $activeSheet->setCellValueExplicit('O'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('P'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('Q'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
                $row++;
            }
        }

        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="qarzdorlik_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

public function actionKassa1prev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('analiz'))==0){
                $analiz = 'all';
            }
            else{
                $analiz = Yii::$app->request->post('analiz');
            }

            if(strlen(Yii::$app->request->post('referal'))==0){
                $referal = 'all';
            }
            else{
                $referal = Yii::$app->request->post('referal');
            }
            $this->kassa1Report($date1,$date2,$referal,$analiz);
        }
        return $this->render('kassa1');
    }

    private function kassa1Report($date1,$date2,$referal,$analiz)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/kassa1.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $filial = Users::getMyFil();
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('C2', $date1, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('D2', $date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('H2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('K2', Referals::getByRefnum($referal), \PHPExcel_Cell_DataType::TYPE_STRING);

        $models = Registration::find()->where(['between','create_date',$date1,$date2]);
        if($filial!='all'){
            $models->andWhere(['in','user_id',Users::getFilUsers($filial)]);
        }
        if($referal!='all'){
            $models->andWhere(['ref_code'=>$referal]);
        }
        if($analiz!='all'){
            $models->andWhere(['in','id',RegAnalizs::getRegIds($analiz)]);
        }
        $res = $models->orderBy(['id'=>SORT_ASC, 'ref_code' => SORT_ASC])->all();
        // var_dump($res);die;
        $row = 5;
        $n=1;
        foreach ($res as $reg) {
            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('B'.$row, $reg->other, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('C'.$row, Client::getName($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('D'.$row, Client::getPhonenum($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('E'.$row, date("d.m.Y", strtotime($reg->create_date)), \PHPExcel_Cell_DataType::TYPE_STRING);
            // var_dump($analiz);die;
            if($analiz!='all'){
                $analizs = RegAnalizs::find()->where(['reg_id'=>$reg->id, 'analiz_id'=>$analiz])->all();
            }
            else{
                $analizs = RegAnalizs::find()->where(['reg_id'=>$reg->id])->all();
            }

            $na = 0;
            foreach ($analizs as $key) {
                $ra = $row+$na;
                $activeSheet->setCellValueExplicit('F'.$ra, SAnaliz::getName($key->analiz_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('G'.$ra, $key->summa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $na++;
            }

            

            $activeSheet->setCellValueExplicit('H'.$row, $reg->sum_amount, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('I'.$row, $reg->skidka_reg+$reg->skidka_kassa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('J'.$row, $reg->sum_amount-($reg->skidka_reg+$reg->skidka_kassa), \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            if($reg->sum_cash>0){
                $k_str = 'Нақд';
            }
            else{
                if($reg->sum_plastik>0){
                    $k_str = 'Пластик';    
                }
                else{
                    $k_str = 'Хабар';
                }   
            }
            $activeSheet->setCellValueExplicit('K'.$row, $k_str, \PHPExcel_Cell_DataType::TYPE_STRING);

            $activeSheet->setCellValueExplicit('L'.$row, $reg->sum_cash+$reg->sum_plastik, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $activeSheet->setCellValueExplicit('M'.$row, $reg->sum_amount-($reg->skidka_reg+$reg->skidka_kassa+$reg->sum_cash+$reg->sum_plastik), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('N'.$row, Users::getNameAndFil($reg->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('O'.$row, $reg->ref_code, \PHPExcel_Cell_DataType::TYPE_STRING);

            $referal = Referals::getByRefnum($reg->ref_code);
            $activeSheet->setCellValueExplicit('P'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('Q'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('R'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
            // $activeSheet->setCellValueExplicit('Q'.$row, $referal->add1, \PHPExcel_Cell_DataType::TYPE_STRING);
            // $activeSheet->setCellValueExplicit('R'.$row, $referal->avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            // $foiz = (int)$referal->add1;
            // $activeSheet->setCellValueExplicit('S'.$row, ($reg->sum_amount-($reg->skidka_reg+$skidka_kassa))*$foiz/100, \PHPExcel_Cell_DataType::TYPE_NUMERIC);




            if($na==0){
                $na=1;
            } 
            $row=$row+$na;
        }

        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="kassa1_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }




/////////////////////////////////////////////////////// LAB /////////////////////////////////////////////////////////////////////////////////////////
    public function actionLab1prev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }

            if(strlen(Yii::$app->request->post('analiz'))==0){
                $analiz = 'all';
            }
            else{
                $analiz = Yii::$app->request->post('analiz');
            }

            if(strlen(Yii::$app->request->post('referal'))==0){
                $referal = 'all';
            }
            else{
                $referal = Yii::$app->request->post('referal');
            }

            $kunlar = Yii::$app->request->post('kunlar');
            $this->lab1Report($date1,$date2,$filial,$referal,$analiz);
        }
        return $this->render('lab1');
    }

    private function lab1Report($date1,$date2,$filial,$referal,$analiz)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/lab1.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('E1', $date1, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('F1', $date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('G1', $filial, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('H1', $referal, \PHPExcel_Cell_DataType::TYPE_STRING);
        // $date

        $models = Registration::find()->where(['between','create_date',$date1,$date2]);
        // var_dump($models);die;
        if($filial!='all'){
            $models->andWhere(['in','user_id',Users::getFilUsers($filial)]);
        }
        if($referal!='all'){
            $models->andWhere(['ref_code'=>$referal]);
        }
        if($analiz!='all'){
            $models->andWhere(['in','id',RegAnalizs::getRegIds($analiz)]);
        }
        $res = $models->orderBy(['id' => SORT_DESC])->all();
        // var_dump($res);die;
        $row = 5;
        $n=1;
        foreach ($res as $reg) {
            $reg_analizs = RegAnalizs::find()->where(['reg_id'=>$reg->id])->all();
            $client = Client::findOne($reg->client_id);
            foreach ($reg_analizs as $key) {
                if($analiz=='all'||$key->analiz_id==$analiz){
                    $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('B'.$row, SAnaliz::getName($key->analiz_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, date("d.m.Y", strtotime($reg->create_date)), \PHPExcel_Cell_DataType::TYPE_STRING);

                    ////
                    

                    $activeSheet->setCellValueExplicit('E'.$row, $reg->other, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $results = Result::find()->where(['main_id'=>$reg->id,'analiz_id'=>$key->analiz_id])->all();
                    foreach ($results as $result) {
                        $activeSheet->setCellValueExplicit('F'.$row, SPokazatel::getName($result->pokaz_id), \PHPExcel_Cell_DataType::TYPE_STRING);

                        $regdopinfo = RegDopinfo::find()->where(['reg_id'=>$reg->id,'indikator_id'=>$result->pokaz_id])->one();
                        if($regdopinfo){
                            $pokaz_limit = PokazLimits::findOne($regdopinfo->value);
                            if($pokaz_limit){
                                $activeSheet->setCellValueExplicit('G'.$row, SPokazatel::getAdd1UlchBirligi($result->pokaz_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                                if(strlen($pokaz_limit->norma)>0){
                                    $activeSheet->setCellValueExplicit('H'.$row, $pokaz_limit->norma, \PHPExcel_Cell_DataType::TYPE_STRING);
                                }
                                else{
                                    $activeSheet->setCellValueExplicit('H'.$row, $pokaz_limit->down_limit.'<->'.$pokaz_limit->up_limit, \PHPExcel_Cell_DataType::TYPE_STRING);
                                }
                            }
                            else{
                                $activeSheet->setCellValueExplicit('H'.$row, 'Норма топилмади', \PHPExcel_Cell_DataType::TYPE_STRING);
                            }   
                        }
                        else{
                            $pokaz_limit = PokazLimits::find()->where(['pokaz_id'=>$result->pokaz_id])->one();
                            if($pokaz_limit){
                                $activeSheet->setCellValueExplicit('G'.$row, SPokazatel::getAdd1UlchBirligi($result->pokaz_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                                if(strlen($pokaz_limit->norma)>0){
                                    $activeSheet->setCellValueExplicit('H'.$row, $pokaz_limit->norma, \PHPExcel_Cell_DataType::TYPE_STRING);
                                }
                                else{
                                    $activeSheet->setCellValueExplicit('H'.$row, $pokaz_limit->down_limit.'<->'.$pokaz_limit->up_limit, \PHPExcel_Cell_DataType::TYPE_STRING);
                                }
                                
                            }
                            else{
                                $activeSheet->setCellValueExplicit('H'.$row, 'Норма топилмади', \PHPExcel_Cell_DataType::TYPE_STRING);
                            }
                        }
                        $activeSheet->setCellValueExplicit('I'.$row, $result->reslut_value, \PHPExcel_Cell_DataType::TYPE_STRING);
                        $activeSheet->setCellValueExplicit('D'.$row, date("d.m.Y", strtotime($result->create_date)), \PHPExcel_Cell_DataType::TYPE_STRING);

                        if(strlen($result->reslut_value)>0){
                            $rang = PokazLimits::getClassByValue($reg->id,$result->pokaz_id,$result->reslut_value);   
                            if($rang['class']=='bg-success'){
                                $activeSheet->getStyle('J'.$row)->applyFromArray(
                                    [
                                        'fill' => [
                                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '71d567')
                                        ]
                                    ]
                                );
                            }
                            elseif($rang['class']=='bg-success'){
                                $activeSheet->getStyle('J'.$row)->applyFromArray(
                                    [
                                        'fill' => [
                                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'fab861')
                                        ]
                                    ]
                                );
                            }
                            else{
                                $activeSheet->getStyle('J'.$row)->applyFromArray(
                                    [
                                        'fill' => [
                                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'FF0000')
                                        ]
                                    ]
                                );
                            }
                        }

                        
                        if($client){
                            $activeSheet->setCellValueExplicit('K'.$row, $client->lname.' '.$client->fname.' '.$client->mname, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('L'.$row, $client->birthdate, \PHPExcel_Cell_DataType::TYPE_STRING);

                            if($client->sex=='F'){
                                $activeSheet->setCellValueExplicit('M'.$row, 'Аёл', \PHPExcel_Cell_DataType::TYPE_STRING);
                            }
                            elseif($client->sex=='M'){
                                $activeSheet->setCellValueExplicit('M'.$row, 'Эркак', \PHPExcel_Cell_DataType::TYPE_STRING);
                            }
                            else{
                                $activeSheet->setCellValueExplicit('M'.$row, 'Киритилмаган', \PHPExcel_Cell_DataType::TYPE_STRING);
                            }
                            
                            

                            $activeSheet->setCellValueExplicit('N'.$row, $client->address_tuman, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('O'.$row, $client->address_text, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('P'.$row, $client->add1, \PHPExcel_Cell_DataType::TYPE_STRING);
                        }
                        
                        $row++;
                        
                    }
                    
                }
            }
        }

        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laborator_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    /////////////////////////////////////////////////////// MONEY SEND /////////////////////////////////////////////////////////////////////////////////////////
    public function actionMoneysendprev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('sendtype'))==0){
                $sendtype = 'all';
            }
            else{
                $sendtype = Yii::$app->request->post('sendtype');
            }

            if(strlen(Yii::$app->request->post('sender'))==0){
                $sender = 'all';
            }
            else{
                $sender = Yii::$app->request->post('sender');
            }

            if(strlen(Yii::$app->request->post('receiver'))==0){
                $receiver = 'all';
            }
            else{
                $receiver = Yii::$app->request->post('receiver');
            }
            $this->moneysendReport($date1,$date2,$sendtype,$sender,$receiver);
        }
        return $this->render('moneysend');
    }

    private function moneysendReport($date1,$date2,$sendtype,$sender,$receiver)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/moneysend.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('C2', $date1.' - '.$date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('E2', $sender, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('G2', $receiver, \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('I2', $sendtype, \PHPExcel_Cell_DataType::TYPE_STRING);
        // $date

        $models = MoneySend::find()->where(['between','send_date',$date1,$date2]);
        // var_dump($models);die;
        if($sender!='all'){
            $models->andWhere(['send_user'=>$sender]);
        }
        if($receiver!='all'){
            $models->andWhere(['rec_user'=>$receiver]);
        }
        if($sendtype!='all'){
            $models->andWhere(['send_type'=>$sendtype]);
        }
        $res = $models->orderBy(['id' => SORT_DESC])->all();
        // var_dump($res);die;
        $row = 5;
        $n=0;
        $arr_type = [1=>'Нақд', 2=>'Пластик'];
        $arr_status = [1=>'Юборилди', 2=>'Қабул қилинди', 3=>'Рад этилди'];
        foreach ($res as $reg) {
            
                    $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('B'.$row, Filials::getName(Users::getFilial($reg->send_user)), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, Users::getName($reg->send_user), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('D'.$row, Filials::getName(Users::getFilial($reg->rec_user)), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('E'.$row, Users::getName($reg->rec_user), \PHPExcel_Cell_DataType::TYPE_STRING);

                    ////

                    $activeSheet->setCellValueExplicit('F'.$row, $arr_type[$reg->send_type], \PHPExcel_Cell_DataType::TYPE_STRING);

                    $activeSheet->setCellValueExplicit('G'.$row, $reg->amount, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                    $activeSheet->setCellValueExplicit('H'.$row, $arr_status[$reg->status], \PHPExcel_Cell_DataType::TYPE_STRING);


                    $activeSheet->setCellValueExplicit('I'.$row, $reg->send_date, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('J'.$row, $reg->rec_date, \PHPExcel_Cell_DataType::TYPE_STRING);
                    
                    $row++;
        }

        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laborator_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

    /////////////////////////////////////////////////////// REAGENT QOLDIQ////////////////////////////////////////////////////////////////////////////////
    public function actionReagentqoldiqprev()
    {
        if(Yii::$app->request->post('_csrf')){
            if(strlen(Yii::$app->request->post('reagent'))==0){
                $reagent = 'all';
            }
            else{
                $reagent = Yii::$app->request->post('reagent');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }
            $this->reagentqoldiqReport($reagent,$filial);
        }
        return $this->render('reagentqoldiq');
    }

    private function reagentqoldiqReport($reagent,$filial)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/reagent_qoldiq.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('C2', date("Y-m-d H:i:s"), \PHPExcel_Cell_DataType::TYPE_STRING);

        if($filial=='all'){
            $activeSheet->setCellValueExplicit('H2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('H2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        if($reagent=='all'){
            $activeSheet->setCellValueExplicit('F2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('F2', Reagent::getName($reagent), \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        
        
        $n=1;
        $row=5;
        if($reagent=='all'){
            
            if($filial==1){
                $models = Reagent::find()->orderBy(['title'=>SORT_ASC])->all();
                $filname = Filials::getName($filial);
                foreach ($models as $model) {
                    $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('B'.$row, $filname.'(Асосий)', \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, $model->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('D'.$row, $model->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('E'.$row, $model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('F'.$row, $model->qoldiq*$model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('G'.$row, $model->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('H'.$row, $model->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $row++;
                }
                $reagent_fils = ReagentFilial::find()->where(['filial_id'=>$filial])->all();
                        foreach($reagent_fils as $reagent_fil){
                            $reagent = Reagent::findOne($reagent_fil->reagent_id);
                            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $row++;
                        }

            }
            elseif($filial=='all'){
                foreach(Filials::getAll() as $key => $value){
                    $filname = Filials::getName($key);
                    if($key==1){
                        $models = Reagent::find()->orderBy(['title'=>SORT_ASC])->all();
                        foreach ($models as $model) {
                            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('B'.$row, $filname.'(Асосий)', \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('C'.$row, $model->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('D'.$row, $model->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('E'.$row, $model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('F'.$row, $model->qoldiq*$model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('G'.$row, $model->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('H'.$row, $model->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $row++;
                        }
                        $reagent_fils = ReagentFilial::find()->where(['filial_id'=>$key])->all();
                        foreach($reagent_fils as $reagent_fil){
                            $reagent = Reagent::findOne($reagent_fil->reagent_id);
                            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $row++;
                        }
                    }
                    else{
                        $reagent_fils = ReagentFilial::find()->where(['filial_id'=>$key])->all();
                        foreach($reagent_fils as $reagent_fil){
                            $reagent = Reagent::findOne($reagent_fil->reagent_id);
                            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $row++;
                        }
                    }
                }
            }
            else{
                $reagent_fils = ReagentFilial::find()->where(['filial_id'=>$filial])->all();
                $filname = Filials::getName($filial);
                foreach($reagent_fils as $reagent_fil){
                    $reagent = Reagent::findOne($reagent_fil->reagent_id);
                    $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $row++;
                }
            }
        }
        else{
            if($filial==1){
                $model = Reagent::findOne($reagent);
                $filname = Filials::getName($filial);
                    $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('B'.$row, $filname.'(Асосий)', \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, $model->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('D'.$row, $model->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('E'.$row, $model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('F'.$row, $model->qoldiq*$model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('G'.$row, $model->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('H'.$row, $model->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $row++;
                $reagent_fil = ReagentFilial::find()->where(['filial_id'=>$filial,'reagent_id'=>$reagent])->one();
                    $reagent = Reagent::findOne($reagent_fil->reagent_id);
                    $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                    $row++;
            }
            elseif($filial=='all'){
                foreach(Filials::getAll() as $key => $value){
                    $filname = Filials::getName($key);
                    $model = Reagent::findOne($reagent);
                    if($key==1){
                            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('B'.$row, $filname.'(Асосий)', \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('C'.$row, $model->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('D'.$row, $model->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('E'.$row, $model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('F'.$row, $model->qoldiq*$model->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('G'.$row, $model->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('H'.$row, $model->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $row++;
                    }
                    else{
                        $reagent_fil = ReagentFilial::find()->where(['filial_id'=>$key,'reagent_id'=>$reagent])->one();
                            $reagent = Reagent::findOne($reagent_fil->reagent_id);
                            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                            $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                            $row++;
                    }
                }
            }
            else{
                $filname = Filials::getName($filial);
                $reagent_fil = ReagentFilial::find()->where(['filial_id'=>$filial,'reagent_id'=>$reagent])->one();
                $reagent = Reagent::findOne($reagent_fil->reagent_id);
                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, $filname, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('C'.$row, $reagent->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('D'.$row, $reagent_fil->qoldiq, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('E'.$row, $reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('F'.$row, $reagent_fil->qoldiq*$reagent->price, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('G'.$row, $reagent->notific_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('H'.$row, $reagent->notific_filial, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $row++;
            }
        }
        
        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reagentqoldiq_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }


////////////////////////////////////////////////////// KASSA TUSHUM CHIQIM //////////////////////////////////////////////////////
    public function actionKassatch1prev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }

            if(strlen(Yii::$app->request->post('sendtype'))==0){
                $sendtype = 'all';
            }
            else{
                $sendtype = Yii::$app->request->post('sendtype');
            }

            
            $this->kassaTushumChiqimReport($date1,$date2,$filial,$sendtype);
        }
        return $this->render('kassatch1');
    }

    private function kassaTushumChiqimReport($date1,$date2,$filial,$sendtype)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/kassatch1.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('C2', $date1.' - '.$date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        if($filial=='all'){
            $activeSheet->setCellValueExplicit('E2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('E2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        }

        $arr_type = [1=>'Нақд', 2=>'Пластик','all'=>'Барчаси'];
        $activeSheet->setCellValueExplicit('G2', $arr_type[$sendtype], \PHPExcel_Cell_DataType::TYPE_STRING); 
        

        $row = 5;
        $n=1;
        if($filial=='all'){
            $filmodels = Filials::getAll();
            foreach($filmodels as $key => $title){
                $filial = $key;
                $models = Payments::find()->where(['between','create_date',$date1,$date2])->andWhere(['in','kassir_id',Users::getFilUsers($filial)]);
                if($sendtype=='all'){
                    $sum_in = $models->sum('cash_sum+plastik_sum');
                }
                else{
                    if($sendtype==1){
                        $sum_in = $models->sum('cash_sum');
                    }
                    else{
                        $sum_in = $models->sum('plastik_sum');
                    }   
                }
                $rasxod = Rasxod::find()->where(['between','create_date',$date1,$date2])->andWhere(['filial_id'=>$filial, 'status'=>2]);
                if($sendtype!='all'){
                    $rasxod = $rasxod->andWhere(['sum_type'=>$sendtype]);
                }
                $rasxod = $rasxod->sum('summa');

                $recsum = MoneySend::find()->where(['between','send_date',$date1,$date2])->andWhere(['in','rec_user',Users::getFilUsers($filial)])->andWhere(['status'=>2]);
                if($sendtype!='all'){
                    $recsum = $recsum->andWhere(['send_type'=>$sendtype]);
                }
                $recsum = $recsum->sum('amount');

                $fqsends = FqSends::find()->where(['between','send_date',$date1,$date2])->andWhere(['status'=>2])->andWhere(['in','fq_id',FilialQoldiq::getFilQoldiqs($filial)]);
                if($sendtype!='all'){
                    $fqsends = $fqsends->andWhere(['send_type'=>$sendtype]);
                }
                $zavkassa_sum = $fqsends->sum('sum');

                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, $title, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('C'.$row, $arr_type[$sendtype], \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('D'.$row, $sum_in, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('E'.$row, $rasxod, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('F'.$row, $recsum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('G'.$row, $zavkassa_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $row++;
            }
        }
        else{
            $title = Filials::getName($filial);
            $models = Payments::find()->where(['between','create_date',$date1,$date2])->andWhere(['in','kassir_id',Users::getFilUsers($filial)]);
                if($sendtype=='all'){
                    $sum_in = $models->sum('cash_sum+plastik_sum');
                }
                else{
                    if($sendtype==1){
                        $sum_in = $models->sum('cash_sum');
                    }
                    else{
                        $sum_in = $models->sum('plastik_sum');
                    }   
                }
                $rasxod = Rasxod::find()->where(['between','create_date',$date1,$date2])->andWhere(['filial_id'=>$filial, 'status'=>2]);
                if($sendtype!='all'){
                    $rasxod = $rasxod->andWhere(['sum_type'=>$sendtype]);
                }
                $rasxod = $rasxod->sum('summa');

                $recsum = MoneySend::find()->where(['between','send_date',$date1,$date2])->andWhere(['in','rec_user',Users::getFilUsers($filial)])->andWhere(['status'=>2]);
                if($sendtype!='all'){
                    $recsum = $recsum->andWhere(['send_type'=>$sendtype]);
                }
                $recsum = $recsum->sum('amount');

                $fqsends = FqSends::find()->where(['between','send_date',$date1,$date2])->andWhere(['status'=>2])->andWhere(['in','fq_id',FilialQoldiq::getFilQoldiqs($filial)]);
                if($sendtype!='all'){
                    $fqsends = $fqsends->andWhere(['send_type'=>$sendtype]);
                }
                $zavkassa_sum = $fqsends->sum('sum');
                
                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, $title, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('C'.$row, $arr_type[$sendtype], \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('D'.$row, $sum_in, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('E'.$row, $rasxod, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('F'.$row, $recsum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('G'.$row, $zavkassa_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

        }


        
        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="kassa_tushum_chiqim_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }


////////////////////////////////////////////////////// REFERAL   //////////////////////////////////////////////////////
    public function actionReferal1prev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }

            if(strlen(Yii::$app->request->post('refcode'))==0){
                $refcode = 'all';
            }
            else{
                $refcode = Yii::$app->request->post('refcode');
            }

            if(strlen(Yii::$app->request->post('shifoxona'))==0){
                $shifoxona = 'all';
            }
            else{
                $shifoxona = Yii::$app->request->post('shifoxona');
            }

            if(strlen(Yii::$app->request->post('lavozim'))==0){
                $lavozim = 'all';
            }
            else{
                $lavozim = Yii::$app->request->post('lavozim');
            }

            
            $this->referal1Report($date1,$date2,$filial,$refcode,$shifoxona,$lavozim);
        }
        return $this->render('referal1');
    }

    private function referal1Report($date1,$date2,$filial,$refcode,$shifoxona,$lavozim)
    {

        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/referal.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('C2', $date1.' - '.$date2, \PHPExcel_Cell_DataType::TYPE_STRING);


        if($filial=='all'){
            $activeSheet->setCellValueExplicit('F2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
            $referals = Referals::find();
        }
        else{
            $activeSheet->setCellValueExplicit('F2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
            $referals = Referals::find()->where(['filial'=>$filial]);
        }

        if($refcode=='all'){
            $activeSheet->setCellValueExplicit('L2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('L2', Referals::getName($refcode), \PHPExcel_Cell_DataType::TYPE_STRING);
            $referals = $referals->andWhere(['refnum'=>$refcode]);
        }

        if($shifoxona=='all'){
            $activeSheet->setCellValueExplicit('H2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('H2', $shifoxona, \PHPExcel_Cell_DataType::TYPE_STRING);
            $referals = $referals->andWhere(['like', 'desc', $shifoxona]);
        }

        if($lavozim=='all'){
            $activeSheet->setCellValueExplicit('J2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('J2', $lavozim, \PHPExcel_Cell_DataType::TYPE_STRING);
            $referals = $referals->andWhere(['like', 'info', $lavozim]);
        }
        $referals = $referals->all();


        $n = 1;
        $row = 5;
        foreach ($referals as $referal) {
            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('B'.$row, Filials::getName($referal->filial), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('C'.$row, $referal->refnum, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('D'.$row, $referal->info, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('E'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('F'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('G'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);

            $reg_count = Registration::find()
                            ->where(['between','create_date',$date1,$date2])
                            ->andWhere(['ref_code'=>$referal->refnum])
                            ->andWhere(['skidka_reg'=>null])
                            ->count();
            $activeSheet->setCellValueExplicit('H'.$row, $reg_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $reg_sum = Registration::find()
                        ->where(['between','create_date',$date1,$date2])
                        ->andWhere(['ref_code'=>$referal->refnum])
                        ->andWhere(['skidka_reg'=>null])
                        ->sum('IFNULL(sum_cash, 0)+IFNULL(sum_plastik, 0)');
            $activeSheet->setCellValueExplicit('I'.$row, $reg_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            if($referal->add1>0){
                $percent_sum = $reg_sum*(int)$referal->add1/100;
            }
            else{
                $percent_sum = (int)$reg_count*$referal->fix_sum;
            }

            $activeSheet->setCellValueExplicit('J'.$row, $percent_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $foyda_sum = $reg_sum-$percent_sum;
            $activeSheet->setCellValueExplicit('K'.$row, $foyda_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);


            $refsend_sum = RefSends::find()->where(['between','send_date',$date1,$date2])->andWhere(['refnum'=>$referal->refnum])->sum('sum');
            $activeSheet->setCellValueExplicit('L'.$row, $foyda_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);


            $activeSheet->setCellValueExplicit('M'.$row, $referal->avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('N'.$row, $referal->avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $row++;
        }


            

        
        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="referallar_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }

////////////////////////////////////////////////////// HARAJATLAR   //////////////////////////////////////////////////////
    public function actionHarajatlar1prev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }

            if(strlen(Yii::$app->request->post('rasxod_type'))==0){
                $rasxod_type = 'all';
            }
            else{
                $rasxod_type = Yii::$app->request->post('rasxod_type');
            }

            if(strlen(Yii::$app->request->post('money_type'))==0){
                $money_type = 'all';
            }
            else{
                $money_type = Yii::$app->request->post('money_type');
            }

            if(strlen(Yii::$app->request->post('refcode'))==0){
                $refcode = 'all';
            }
            else{
                $refcode = Yii::$app->request->post('refcode');
            }

            
            $this->harajatlar1Report($date1,$date2,$filial,$rasxod_type,$money_type,$refcode);
        }
        return $this->render('harajatlar1');
    }

    private function harajatlar1Report($date1,$date2,$filial,$rasxod_type,$money_type,$refcode)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/harajatlar.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();

        $money_type_arr = [1=>'Нақд', 2=>'Пластик','all'=>'Барчаси'];
        $status_arr = ['1'=>'Юборилди', '2'=>'Қабул қилинди', '3'=>'Рад этилди'];



        $activeSheet->setCellValueExplicit('C2', $date1.' - '.$date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        
        if($filial=='all'){
            $activeSheet->setCellValueExplicit('E2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('E2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        $activeSheet->setCellValueExplicit('G2', SRasxodTypes::getName($rasxod_type), \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('I2', $money_type_arr[$money_type], \PHPExcel_Cell_DataType::TYPE_STRING);
        if($refcode=='all'){
            $activeSheet->setCellValueExplicit('K2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('K2', Referals::getName($refcode), \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        
        $row = 5;
        $n=1;

        $rasxods = Rasxod::find()->where(['between','create_date',$date1,$date2]);
        if($filial!='all'){
            $rasxods = $rasxods->andWhere(['filial_id'=>$filial]);
        }
        if($rasxod_type!='all'){
            $rasxods = $rasxods->andWhere(['rasxod_type'=>$rasxod_type]);
        }
        if($money_type!='all'){
            $rasxods = $rasxods->andWhere(['sum_type'=>$money_type]);
        }
        if($refcode!='all'){
            $rasxods = $rasxods->andWhere(['referal_id'=>$refcode]);
        }
        $rasxods = $rasxods->all();

        foreach ($rasxods as $rasxod) {
            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('B'.$row, Filials::getName($rasxod->filial_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('C'.$row, Users::getName($rasxod->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('D'.$row, $money_type_arr[$rasxod->sum_type], \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('E'.$row, $rasxod->summa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('F'.$row, SRasxodTypes::getName($rasxod->rasxod_type), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('G'.$row, $rasxod->rasxod_desc, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('H'.$row, $rasxod->create_date, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('I'.$row, $rasxod->rasxod_period, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('J'.$row, $status_arr[$rasxod->status], \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('K'.$row, Users::getName($rasxod->send_user), \PHPExcel_Cell_DataType::TYPE_STRING);
            if(strlen($rasxod->referal_id)>0){
                $refmodel = Referals::getByRefnum($rasxod->referal_id);
                $activeSheet->setCellValueExplicit('L'.$row, $rasxod->referal_id, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('M'.$row, $refmodel->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('N'.$row, $refmodel->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('O'.$row, $refmodel->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $row++;
        }
        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="harajatlar_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }


////////////////////////////////////////////////////// BIZNES PLAN   //////////////////////////////////////////////////////
    public function actionBp1prev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }            
            $this->bp1Report($date1,$date2,$filial);
        }
        return $this->render('bp1');
    }

    private function bp1Report($date1,$date2,$filial)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/bp.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();

        $activeSheet->setCellValueExplicit('H4', $date1.' - '.$date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        
        if($filial=='all'){
            $activeSheet->setCellValueExplicit('C4', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('C4', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        
        $row = 8;
        $n=1;

        $covid_analizs = SAnaliz::find()->select('id')->where(['in','group_id',[19,26]])->all();
        $covid_analizs = ArrayHelper::map($covid_analizs, 'id', 'id');

        $other_analizs = SAnaliz::find()->select('id')->where(['not in','group_id',[19,26]])->all();
        $other_analizs = ArrayHelper::map($other_analizs, 'id', 'id');

        if($filial=='all'){
            $filials = Filials::find()->all();
            foreach ($filials as $fil) {
                $users_arr = Users::getFilUsers($fil->id);
                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, $fil->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                $reg_analizs_covid = RegAnalizs::getRegIdsByAnalizsArray($covid_analizs);
                $covid_sum = Registration::find()
                                ->where(['between','create_date',$date1,$date2])
                                ->andWhere(['in','user_id',$users_arr])
                                ->andWhere(['in', 'id', $reg_analizs_covid])
                                ->sum('IFNULL(sum_amount,0)-IFNULL(sum_debt,0)-IFNULL(skidka_reg,0)');
                $reg_analizs_other = RegAnalizs::getRegIdsByAnalizsArray($other_analizs);
                $other_sum = Registration::find()
                                ->where(['between','create_date',$date1,$date2])
                                ->andWhere(['in','user_id',$users_arr])
                                ->andWhere(['in', 'id', $reg_analizs_other])
                                ->sum('IFNULL(sum_amount,0)-IFNULL(sum_debt,0)-IFNULL(skidka_reg,0)');
                $activeSheet->setCellValueExplicit('F'.$row, $covid_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('G'.$row, $other_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);


                $reg_count = Registration::find()->where(['between','create_date',$date1,$date2])
                                ->andWhere(['in','user_id',$users_arr])
                                ->count();
                $activeSheet->setCellValueExplicit('O'.$row, $reg_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $fil_qoldiqs = FilialQoldiq::getFilQoldiqs($fil->id);
                $zavkassa_sum = FqSends::find()->where(['in','fq_id', $fil_qoldiqs])
                                    ->andWhere(['not in','fq_id',[8,28,44,45]])
                                    ->andWhere(['between', 'send_date', $date1,$date2])
                                    ->andWhere(['status'=>2])
                                    ->sum('sum');
                $activeSheet->setCellValueExplicit('P'.$row, $zavkassa_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                
                $rasxod_sum = Rasxod::find()->where(['filial_id'=>$fil->id])
                                ->andWhere(['between','create_date',$date1,$date2])
                                ->andWhere(['status'=>2])
                                ->sum('summa');
                $activeSheet->setCellValueExplicit('Q'.$row, $rasxod_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $agent_sum = Rasxod::find()
                            ->where(['filial_id'=>$fil->id])
                            ->andWhere(['rasxod_type'=>2])
                            ->andWhere(['status'=>2])
                            ->andWhere(['between','create_date',$date1,$date2])
                            ->sum('summa');
                $activeSheet->setCellValueExplicit('R'.$row, $agent_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $qarz_sum = Registration::getQarzSumFil($fil->id);
                $activeSheet->setCellValueExplicit('S'.$row, $qarz_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $avans_sum = Referals::find()->where(['filial'=>$fil->id])->sum('avans_sum');
                $activeSheet->setCellValueExplicit('T'.$row, $avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $row++;
            }

            $frow = $row-1;
            $activeSheet->setCellValueExplicit('B'.$row, 'Жами', \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('C'.$row, '=SUM(C8:C'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('D'.$row, '=SUM(D8:D'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('E'.$row, '=SUM(E8:E'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('F'.$row, '=SUM(F8:F'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('G'.$row, '=SUM(G8:G'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('H'.$row, '=SUM(H8:H'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('I'.$row, '=SUM(I8:I'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('J'.$row, '=SUM(J8:J'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('K'.$row, '=SUM(K8:K'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('L'.$row, '=SUM(L8:L'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('M'.$row, '=SUM(M8:M'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('N'.$row, '=SUM(N8:N'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('O'.$row, '=SUM(O8:O'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('P'.$row, '=SUM(P8:P'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('Q'.$row, '=SUM(Q8:Q'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('R'.$row, '=SUM(R8:R'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('S'.$row, '=SUM(S8:S'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);
            $activeSheet->setCellValueExplicit('T'.$row, '=SUM(T8:T'.$frow.')', \PHPExcel_Cell_DataType::TYPE_FORMULA);

        }
        else{
            $fil = Filials::findOne($filial);
                $users_arr = Users::getFilUsers($fil->id);
                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, $fil->title, \PHPExcel_Cell_DataType::TYPE_STRING);
                $reg_analizs_covid = RegAnalizs::getRegIdsByAnalizsArray($covid_analizs);
                $covid_sum = Registration::find()
                                ->where(['between','create_date',$date1,$date2])
                                ->andWhere(['in','user_id',$users_arr])
                                ->andWhere(['in', 'id', $reg_analizs_covid])
                                ->sum('IFNULL(sum_amount,0)-IFNULL(sum_debt,0)-IFNULL(skidka_reg,0)');
                $reg_analizs_other = RegAnalizs::getRegIdsByAnalizsArray($other_analizs);
                $other_sum = Registration::find()
                                ->where(['between','create_date',$date1,$date2])
                                ->andWhere(['in','user_id',$users_arr])
                                ->andWhere(['in', 'id', $reg_analizs_other])
                                ->sum('IFNULL(sum_amount,0)-IFNULL(sum_debt,0)-IFNULL(skidka_reg,0)');
                $activeSheet->setCellValueExplicit('F'.$row, $covid_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('G'.$row, $other_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);


                $reg_count = Registration::find()->where(['between','create_date',$date1,$date2])
                                ->andWhere(['in','user_id',$users_arr])
                                ->count();
                $activeSheet->setCellValueExplicit('O'.$row, $reg_count, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $fil_qoldiqs = FilialQoldiq::getFilQoldiqs($fil->id);
                $zavkassa_sum = FqSends::find()->where(['in','fq_id', $fil_qoldiqs])
                                    ->andWhere(['not in','fq_id',[8,28,44,45]])
                                    ->andWhere(['between', 'send_date', $date1,$date2])
                                    ->andWhere(['status'=>2])
                                    ->sum('sum');
                $activeSheet->setCellValueExplicit('P'.$row, $zavkassa_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                
                $rasxod_sum = Rasxod::find()->where(['filial_id'=>$fil->id])
                                ->andWhere(['between','create_date',$date1,$date2])
                                ->andWhere(['status'=>2])
                                ->sum('summa');
                $activeSheet->setCellValueExplicit('Q'.$row, $rasxod_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $agent_sum = Rasxod::find()
                            ->where(['filial_id'=>$fil->id])
                            ->andWhere(['rasxod_type'=>2])
                            ->andWhere(['status'=>2])
                            ->andWhere(['between','create_date',$date1,$date2])
                            ->sum('summa');
                $activeSheet->setCellValueExplicit('R'.$row, $agent_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $qarz_sum = Registration::getQarzSumFil($fil->id);
                $activeSheet->setCellValueExplicit('S'.$row, $qarz_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                $avans_sum = Referals::find()->where(['filial'=>$fil->id])->sum('avans_sum');
                $activeSheet->setCellValueExplicit('T'.$row, $avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

        }

        


        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="bp_bajarilishi_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }




////////////////////////////////////////////////////// REAGENT SARFI   //////////////////////////////////////////////////////
    public function actionReagentsarfiprev()
    {
        if(Yii::$app->request->post('date1')){
            if(strlen(Yii::$app->request->post('date1'))==0){
                $date1 = date("Y-m-d");
            }
            else{
                $date1 = Yii::$app->request->post('date1');
            }

            if(strlen(Yii::$app->request->post('date2'))==0){
                $date2 = date("Y-m-d");
            }
            else{
                $date2 = Yii::$app->request->post('date2');
            }

            if(strlen(Yii::$app->request->post('filial'))==0){
                $filial = 'all';
            }
            else{
                $filial = Yii::$app->request->post('filial');
            }            
            $this->reagentsarfiReport($date1,$date2,$filial);
        }
        return $this->render('reagent_sarfi');
    }

    private function reagentsarfiReport($date1,$date2,$filial)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(20 * 60);

        require('../vendor/PHPExcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/reagent_sarf.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();

        $activeSheet->setCellValueExplicit('D2', $date1.' - '.$date2, \PHPExcel_Cell_DataType::TYPE_STRING);
        $regs = Registration::find()->where(['between','create_date',$date1,$date2]);
        if($filial=='all'){
            $activeSheet->setCellValueExplicit('H2', 'Барчаси', \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        else{
            $activeSheet->setCellValueExplicit('H2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
            $users_arr = Users::getFilUsers($filial);
            $regs = $regs->andWhere(['in','user_id',$users_arr]);
        }
        $regs->orderBy(['id'=>SORT_DESC])->all();
        $row = 5;
        $n=1;

        foreach ($regs as $reg) {
            $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('B'.$row, Filials::getName(Users::getFilial($reg->user_id)), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('C'.$row, Client::getName($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('D'.$row, Client::getPhonenum($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('E'.$row, $reg->create_date, \PHPExcel_Cell_DataType::TYPE_STRING);

            $activeSheet->setCellValueExplicit('F'.$row, $reg->sum_amount, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('G'.$row, $reg->sum_cash+$reg->sum_plastik, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $reg_sum = RegReagents::getSum($reg->id);
            $activeSheet->setCellValueExplicit('H'.$row, $reg_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('I'.$row, $reg->sum_debt, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $ref_sum = Referals::getSumByRegid($reg->id);
            $activeSheet->setCellValueExplicit('J'.$row, $ref_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

            $foyda = ($reg->sum_cash+$reg->sum_plastik)-$reg_sum-$ref_sum-$sum_debt;
            $activeSheet->setCellValueExplicit('K'.$row, $foyda, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $row++;
        }
        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reagent_sarfi_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }
}