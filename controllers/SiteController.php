<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Payments;
use app\models\SystemErrors;
use Fpdf\Fpdf;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('index_notguest');
        }
        return $this->render('index');
    }



    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTest()
    {
        $cp_model = Payments::find()->where(['main_id'=>'9971'])->andWhere(['between', 'create_date', date("Y-m-d H:i:s", strtotime("2021-06-02 02:05:22")-60), date("Y-m-d H:i:s", strtotime("2021-06-02 02:05:22")+60)])->one();//->createCommand()->getRawSql();
        var_dump($cp_model);die;
        die;
        $str = '{"token_type":"Bearer","expires_at":1612310159,"expires_in":21397,"refresh_token":"fe3c0a12cb83cf274a966dc95104913f6337ba38","access_token":"824f947107008b6f883baca870454ebd2f8eb236","athlete":{"id":59692827,"username":"atuhtasinov","resource_state":2,"firstname":"Avaz","lastname":"Tuhtasinov","city":null,"state":null,"country":null,"sex":"M","premium":false,"summit":false,"created_at":"2020-05-28T04:38:13Z","updated_at":"2021-01-12T16:44:40Z","badge_type_id":0,"profile_medium":"https://lh3.googleusercontent.com/a-/AOh14GgIDZFwp1uWS2ZfzPb9fgojfRYKwUMy9O6uCfVg=s96-c","profile":"https://lh3.googleusercontent.com/a-/AOh14GgIDZFwp1uWS2ZfzPb9fgojfRYKwUMy9O6uCfVg=s96-c","friend":null,"follower":null}}';
        // $arr = preg_replace('/[^A-Za-z0-9 _\-\+\&\"\:\,\{\\/\=\?\\\\.}]/','',$str);
        // $arr = str_replace('\u0026','&',$arr);
        $arr = json_decode($str);
        var_dump($arr);die;    
    }

    public function actionQarzdorreport()
    {
        // ini_set('memory_limit', '512M');
        // set_time_limit(20 * 60);

        require('../vendor/phpoffice/phpexcel/Classes/PHPExcel.php');

        $objPHPExcel = new \PHPExcel;
        
        $url = './excel/qarzdor.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($url);
        $sheet = 0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setCellValueExplicit('A8', 'Test', \PHPExcel_Cell_DataType::TYPE_STRING);
        // die;
        
        // $models = Dopsale::find()->where(['state'=>5])->all();
        // $row = 2;
        // foreach ($models as $model) {
        //         $activeSheet->setCellValueExplicit('A'.$row, $row-1, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        //         $activeSheet->setCellValueExplicit('B'.$row, $model->shop_uid, \PHPExcel_Cell_DataType::TYPE_STRING);
        //         $activeSheet->setCellValueExplicit('C'.$row, $model->user_id, \PHPExcel_Cell_DataType::TYPE_STRING);
        //         $activeSheet->setCellValueExplicit('D'.$row, User::getName($model->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);

        //         $activeSheet->setCellValueExplicit('E'.$row, $model->product1, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        //         $activeSheet->setCellValueExplicit('F'.$row, $model->product2, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        //         $activeSheet->setCellValueExplicit('G'.$row, $model->product3, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
        //         $activeSheet->setCellValueExplicit('H'.$row, $model->product5, \PHPExcel_Cell_DataType::TYPE_NUMERIC);

        //         $activeSheet->setCellValueExplicit('I'.$row, User::getAddress($model->user_id), \PHPExcel_Cell_DataType::TYPE_STRING);
        //         $activeSheet->setCellValueExplicit('J'.$row, $model->promocode, \PHPExcel_Cell_DataType::TYPE_STRING);
            
        //     $row++;
        // }


        
 
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,  "Excel2007");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Qarzdorlar_'.date("Y-m-d").'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit;
    }


    public function actionTest1()
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        // $pdf->Cell(40,10,'Hello World!');
        $pdf->WriteHTML('avaz');
        return $pdf->Output();
        // return $this->render('test');
    }

    public function actionTestarduino($key=1)
    {
        $systemerror = new SystemErrors();
        $systemerror->err_action = 'site/testarduino&key='.$key;
        $systemerror->err_action = 'This is arduino test. Key is '.$key;
        $systemerror->create_date = date('Y-m-d H:i:s');
        if($systemerror->save()){
            return Yii::$app->response->setStatusCode(200)->send();
        }
        else{
            return Yii::$app->response->setStatusCode(301)->send();
        }
    }
    
}
