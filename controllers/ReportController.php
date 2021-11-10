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
        $activeSheet->setCellValueExplicit('H2', Filials::getName($filial), \PHPExcel_Cell_DataType::TYPE_STRING);
        $activeSheet->setCellValueExplicit('K2', $referal, \PHPExcel_Cell_DataType::TYPE_STRING);

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
        // var_dump($res);die;
        $row = 3;
        $n=1;
        foreach ($res as $reg) {
            if(round((time()-strtotime($reg->create_date))/60/60/24)>$kunlar){
                $activeSheet->setCellValueExplicit('A'.$row, $n++, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('B'.$row, Client::getName($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('C'.$row, Users::getNameAndFil($reg->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('D'.$row, Client::getPhonenum($reg->client_id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('E'.$row, date("d.m.Y", strtotime($reg->create_date)), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('F'.$row, Result::getMaxDate($reg->id), \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('G'.$row, round((time()-strtotime($reg->create_date))/60/60/24), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('H'.$row, $reg->skidka_reg+$skidka_kassa, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('I'.$row, $reg->sum_cash+$reg->sum_plastik, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('J'.$row, $reg->sum_debt, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $activeSheet->setCellValueExplicit('K'.$row, $reg->ref_code, \PHPExcel_Cell_DataType::TYPE_STRING);
                $referal = Referals::getByRefnum($reg->ref_code);
                $activeSheet->setCellValueExplicit('L'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('M'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
                $activeSheet->setCellValueExplicit('N'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
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
            $models->andWhere(['receiver'=>$receiver]);
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
                    $activeSheet->setCellValueExplicit('B'.$row, Filials::getName(Users::getFilial($reg->sender)), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('C'.$row, Users::getName($reg->sender), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('D'.$row, Filials::getName(Users::getFilial($reg->receiver)), \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('E'.$row, Users::getName($reg->receiver), \PHPExcel_Cell_DataType::TYPE_STRING);

                    ////

                    $activeSheet->setCellValueExplicit('F'.$row, $arr_type[$reg->send_type], \PHPExcel_Cell_DataType::TYPE_STRING);

                    $activeSheet->setCellValueExplicit('G'.$row, $reg->amount, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

                    $activeSheet->setCellValueExplicit('H'.$row, $arr_status[$reg->status], \PHPExcel_Cell_DataType::TYPE_STRING);


                    $activeSheet->setCellValueExplicit('I'.$row, $reg->send_date, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $activeSheet->setCellValueExplicit('J'.$row, $reg->rec_date, \PHPExcel_Cell_DataType::TYPE_STRING);
                    
        }

        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laborator_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }
}