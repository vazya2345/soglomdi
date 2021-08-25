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
use app\models\RegAnalizs;
use app\models\SAnaliz;



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
        $activeSheet->setCellValueExplicit('H2', $filial, \PHPExcel_Cell_DataType::TYPE_STRING);
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
            $activeSheet->setCellValueExplicit('K'.$row, $reg->sum_amount-($reg->skidka_reg+$reg->skidka_kassa+$reg->sum_cash+$reg->sum_plastik), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        	$activeSheet->setCellValueExplicit('L'.$row, Users::getNameAndFil($reg->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('M'.$row, $reg->ref_code, \PHPExcel_Cell_DataType::TYPE_STRING);

        	$referal = Referals::getByRefnum($reg->ref_code);
        	$activeSheet->setCellValueExplicit('N'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('O'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('P'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('Q'.$row, $referal->add1, \PHPExcel_Cell_DataType::TYPE_STRING);
        	$activeSheet->setCellValueExplicit('R'.$row, $referal->avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        	$foiz = (int)$referal->add1;
        	$activeSheet->setCellValueExplicit('S'.$row, ($reg->sum_amount-($reg->skidka_reg+$skidka_kassa))*$foiz/100, \PHPExcel_Cell_DataType::TYPE_NUMERIC);




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
        $activeSheet->setCellValueExplicit('H2', $filial, \PHPExcel_Cell_DataType::TYPE_STRING);
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
            $activeSheet->setCellValueExplicit('K'.$row, $reg->sum_amount-($reg->skidka_reg+$reg->skidka_kassa+$reg->sum_cash+$reg->sum_plastik), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            $activeSheet->setCellValueExplicit('L'.$row, Users::getNameAndFil($reg->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('M'.$row, $reg->ref_code, \PHPExcel_Cell_DataType::TYPE_STRING);

            $referal = Referals::getByRefnum($reg->ref_code);
            $activeSheet->setCellValueExplicit('N'.$row, $referal->desc, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('O'.$row, $referal->fio, \PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->setCellValueExplicit('P'.$row, $referal->phone, \PHPExcel_Cell_DataType::TYPE_STRING);
            // $activeSheet->setCellValueExplicit('Q'.$row, $referal->add1, \PHPExcel_Cell_DataType::TYPE_STRING);
            // $activeSheet->setCellValueExplicit('R'.$row, $referal->avans_sum, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
            // $foiz = (int)$referal->add1;
            // $activeSheet->setCellValueExplicit('S'.$row, ($reg->sum_amount-($reg->skidka_reg+$skidka_kassa))*$foiz/100, \PHPExcel_Cell_DataType::TYPE_NUMERIC);





            $row=$row+$na;
        }

        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="kassa1_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }


}