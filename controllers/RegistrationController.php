<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Registration;
use app\models\RegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Client;
use app\models\RegDopinfo;
use app\models\Result;
use app\models\Users;
use app\models\SAnaliz;
use app\models\SGroups;
use app\models\RegAnalizs;
use app\models\ResultSearch;
use app\models\FinishPayments;
use app\models\Payments;
use app\models\Reagent;
use app\models\Referals;
use app\models\SmsTemplates;
use app\models\SendSms;
use app\models\Filials;
/**
 * RegistrationController implements the CRUD actions for Registration model.
 */
class RegistrationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['viewqr'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        // 'actions' => ['*'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Registration models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/index']);
        }
        if(Yii::$app->user->getRole()==4||Yii::$app->user->getRole()==5||Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9){
            return $this->redirect(['indexlab']);
        }
        elseif(Yii::$app->user->getRole()==7){
            $myfil_users_arr = Users::getMyFilUsers();
            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['in', 'user_id', $myfil_users_arr]);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('indexlab_filial', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        elseif(Yii::$app->user->getRole()==2||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==6){
            $myfil_users_arr = Users::getMyFilUsers();
            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['in', 'user_id', $myfil_users_arr]);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        elseif(Yii::$app->user->getRole()==8){
            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['ref_code'=>Referals::getMyRefCode()]);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('index_referal', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return $this->redirect(['site/index']);
        }
    }

    public function actionIndexkassa()
    {
        if(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==2){
            return $this->redirect(['index']);
        }
        elseif(Yii::$app->user->getRole()==4||Yii::$app->user->getRole()==5){
            return $this->redirect(['indexlab']);
        }
        elseif(Yii::$app->user->getRole()==3){
            $myfil_users_arr = Users::getMyFilUsers();

            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['in', 'user_id', $myfil_users_arr]);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('indexkassa', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return $this->redirect(['index']);
        }
    }

    public function actionIndexupdate()
    {
        if(Yii::$app->user->getRole()==3){
            $myfil_users_arr = Users::getMyFilUsers();

            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['in', 'user_id', $myfil_users_arr]);
            $dataProvider->query->andWhere(['status'=>1]);
            $dataProvider->query->andWhere(['sum_cash'=>NULL,'sum_plastik'=>NULL]);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('index_update', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return $this->redirect(['index']);
        }
    }

    public function actionIndexlab()
    {
        if(Yii::$app->user->getRole()==2){
            return $this->redirect(['index']);
        }
        elseif(Yii::$app->user->getRole()==3){
            $searchModel = new RegistrationSearch();
	        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	        $reg_ids = RegAnalizs::getRegIdsByAnalizsArray(SAnaliz::getFilAnalizs());
            // var_dump($reg_ids);die;
			$dataProvider->query->andWhere(['user_id'=>Yii::$app->user->getId()]);
			$dataProvider->query->andWhere(['in','id',$reg_ids]);
	        $dataProvider->setSort([
	            'defaultOrder' => ['id'=>SORT_DESC],
	        ]);
        }
        elseif(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9){
            $searchModel = new RegistrationSearch();
	        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	        $dataProvider->setSort([
	            'defaultOrder' => ['id'=>SORT_DESC],
	        ]);
        }
        elseif(Yii::$app->user->getRole()==5){
            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
        }
        else{
        	$searchModel = new RegistrationSearch();
	        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	        $reg_ids = RegAnalizs::getRegIdsByAnalizsArray(SAnaliz::getAnalizsByLabUserid(Yii::$app->user->getId()));
			$dataProvider->query->andWhere(['in','id',$reg_ids]);
	        $dataProvider->setSort([
	            'defaultOrder' => ['id'=>SORT_DESC],
	        ]);
        }
        
        return $this->render('indexlab', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKassatulov($id)
    {
        if(Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->kassir_id = Yii::$app->user->id;
            $model->sum_debt = (int)$model->sum_amount-((int)$model->sum_cash+(int)$model->sum_plastik+(int)$model->skidka_reg+(int)$model->skidka_kassa);
            if($model->save()){

                
                $s1 = (int)$model->sum_amount;
                $s2 = (int)$model->sum_cash+(int)$model->sum_plastik+(int)$model->skidka_reg+(int)$model->skidka_kassa;

                $payment_model = new Payments();
                $payment_model->main_id = $id;
                $payment_model->kassir_id = Yii::$app->user->id;
                $payment_model->cash_sum = (int)$model->sum_cash;
                $payment_model->plastik_sum = (int)$model->sum_plastik;
                $payment_model->create_date = date("Y-m-d H:i:s");
                $cp_model = Payments::find()->where(['main_id'=>$id])->andWhere(['between', 'create_date', date("Y-m-d H:i:s", strtotime($payment_model->create_date)-60), date("Y-m-d H:i:s", strtotime($payment_model->create_date)+60)])->one();
                if(!$cp_model){
                    if($payment_model->save()){
                        if($s1<=$s2){
                            $fmodel = new FinishPayments();
                            $fmodel->id = $id;
                            $fmodel->time = date("Y-m-d H:i:s");
                            $fmodel->user_id = Yii::$app->user->id;
                            if($fmodel->save()){
                                $this->sendKassaSms($id);
                                return $this->redirect(['indexkassa']);
                            }
                            else{
                                var_dump($fmodel->errors);die;
                            }
                        }
                    }
                    else{
                        var_dump($payment_model->errors);die;
                    }
                }
                else{
                    echo "Тўлов икки марта ўтиб кетиш хавфи пайдо бўлди.";die;
                }
            }
            
            return $this->redirect(['indexkassa']);
        }

        return $this->render('kassatulov', [
            'model' => $model,
        ]);
    }

    public function actionKassachek($id)
    {
        // Yii::$app->response->format = 'pdf';
        $this->layout = '//chek';


        if(Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);

        return $this->render('kassachek', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Registration model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Registration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Registration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Registration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Registration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Registration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Registration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Registration::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionResult($id)
    {
        if(Registration::getIsPay($id)&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==2||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==6)){
            $model = $this->findModel($id);
            $analizs = RegAnalizs::find()->where(['reg_id'=>$id])->all();
            $i = 0;
            $analiz_names = [];
            foreach ($analizs as $analiz) {
                Result::checkPokazs($id,$analiz->analiz_id);
                Result::checkPokazs($id,$analiz->analiz_id);
                $searchModel[$i] = new ResultSearch();
                $dataProvider[$i] = $searchModel[$i]->search(Yii::$app->request->queryParams);
                $dataProvider[$i]->query->andWhere(['main_id'=>$id,'analiz_id'=>$analiz->analiz_id]);
                $analiz_names[$i]['name'] = SAnaliz::getName($analiz->analiz_id);
                $analiz_names[$i]['add1'] = SAnaliz::getAdd1($analiz->analiz_id);
                $analiz_names[$i]['analiz'] = $analiz->analiz_id;
                $dataProvider[$i]->pagination = ['pageSize' => 100];
                $i++;
            }

            if($i>0){
                return $this->render('result_view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'analiz_names' => $analiz_names,
                ]);
            }
            else{
                return $this->render('result', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);    
            }
        }
        else{
            if(Registration::getIsPay($id)&&(Yii::$app->user->getRole()==8)){
                $model = $this->findModel($id);
                $analizs = RegAnalizs::find()->where(['reg_id'=>$id])->all();
                $i = 0;
                $analiz_names = [];
                foreach ($analizs as $analiz) {
                    Result::checkPokazs($id,$analiz->analiz_id);
                    Result::checkPokazs($id,$analiz->analiz_id);
                    $searchModel[$i] = new ResultSearch();
                    $dataProvider[$i] = $searchModel[$i]->search(Yii::$app->request->queryParams);
                    $dataProvider[$i]->query->andWhere(['main_id'=>$id,'analiz_id'=>$analiz->analiz_id]);
                    $analiz_names[$i]['name'] = SAnaliz::getName($analiz->analiz_id);
                    $analiz_names[$i]['add1'] = SAnaliz::getAdd1($analiz->analiz_id);
                    $analiz_names[$i]['analiz'] = $analiz->analiz_id;
                    $dataProvider[$i]->pagination = ['pageSize' => 100];
                    $i++;
                }

                if($i>0){
                    return $this->render('result_view', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'analiz_names' => $analiz_names,
                    ]);
                }
                else{
                    return $this->render('result', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]);    
                }
            }
            else{
                return $this->render('not_pay');    
            }
        }
        
    }

    public function actionPrint($analiz_id,$reg_id)
    {
        if(!Registration::getIsPay($reg_id)){
            return $this->render('not_pay');  
        }
        Yii::$app->response->format = 'pdf';
        $this->layout = '//print';
        $model = $this->findModel($reg_id);
        Result::checkPokazs($reg_id,$analiz_id);
        $searchModel = new ResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['main_id'=>$reg_id,'analiz_id'=>$analiz_id]);
        $dataProvider->pagination = ['pageSize' => 100];
        $i=2;
        if($i>1){
            return $this->render('print', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'analiz_id' => $analiz_id,
            ]);
        }
        else{
            return;    
        }
        
    }

    public function actionPrintGroup($group,$reg_id)
    {
        if(!Registration::getIsPay($reg_id)){
            return $this->render('not_pay');  
        }
        Yii::$app->response->format = 'pdf';
        $this->layout = '//print';
        


        $model = $this->findModel($reg_id);

        $analizs = RegAnalizs::getAnalizsByGroup($group,$reg_id);
        $check_chegara = 0;
        foreach ($analizs as $key => $value){
            Result::checkPokazs($reg_id,$value);
            if($value==252||$value==253||$value==134||$value==261||$value==250||$value==249){
                $check_chegara=1;
                $group = 'КОВИД';
            }
        }
            $searchModel = new ResultSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['main_id'=>$reg_id])->andWhere(['in','analiz_id',$analizs]);
            $dataProvider->pagination = ['pageSize' => 100];
        // var_dump($group);die;
        if($check_chegara==1){
            return $this->render('print_group_chegara', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'analizs' => $analizs,
                'group' => $group,
            ]);
        }
        else{
            return $this->render('print_group', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'analizs' => $analizs,
                'group' => $group,
            ]);
        }
        
        
    }

    public function actionResultlab($id)
    {
        if(Yii::$app->user->getRole()!=4&&Yii::$app->user->getRole()!=5&&Yii::$app->user->getRole()!=7&&Yii::$app->user->getRole()!=3&&Yii::$app->user->getRole()!=1&&Yii::$app->user->getRole()!=9){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        $analizs = RegAnalizs::find()->where(['reg_id'=>$id])->all();
        $i = 0;
        $analiz_names = [];
        foreach ($analizs as $analiz) {
            Result::checkPokazs($id,$analiz->analiz_id);
            $searchModel[$i] = new ResultSearch();
            $dataProvider[$i] = $searchModel[$i]->search(Yii::$app->request->queryParams);
            $dataProvider[$i]->query->andWhere(['main_id'=>$id,'analiz_id'=>$analiz->analiz_id]);
            $analiz_names[$i] = SAnaliz::getName($analiz->analiz_id);
            $dataProvider[$i]->pagination = ['pageSize' => 100];
            $i++;
        }        
        return $this->render('resultlab', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'analiz_names' => $analiz_names,
            'analizs' => $analizs,
        ]);    
    
        
    }

    public function actionSave($id)
    {
        $pokazs = Yii::$app->request->post('pokaz');
        // var_dump(Yii::$app->request->post('pokaz'));die;
        foreach ($pokazs as $pokaz => $value) {
            if(strpos($pokaz, 'a')){
                if(strlen($value)>0){
                    $pokaz = trim($pokaz,'a');
                }
            }
            // var_dump($value);die;
            if(strlen($value)>0){            
                $model = Result::find()->where(['id'=>$pokaz])->one();
                if($model){
                    $model->reslut_value = $value;
                    $model->user_id = Yii::$app->user->id;
                    $model->create_date = date("Y-m-d H:i:s");
                    // var_dump($model->errors);die;
                    $model->save(false);
                }
            }
        }
        $model = $this->findModel($id);
        
        if(Result::isEndedReg($id)){ 
            $model->status = 4;
            $model->natija_input = 1;
            $this->sendReadySms($id);  
        }
        else{
            $model->status = 3;
            $model->natija_input = 0;
        }
        
        $model->save(false);
        return $this->redirect(['resultsaved', 'id' => $id]);
    }

    public function actionResultsaved($id)
    {
        return $this->render('result_saved');
    }

    public function actionNew()
    {
        if(Yii::$app->user->getRole()!=2&&Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $model = new Registration();
        $model_client = new Client();
        

        if ($model->load(Yii::$app->request->post())&&$model_client->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->kassir_id = Yii::$app->user->id;
            $model->natija_input = '0';
            $model->create_date = date("Y-m-d H:i:s");
            $model->change_time = $model->create_date;

            if($model_client==Client::getClientByDoc($model_client->doc_seria,$model_client->doc_number)){
                $model_client->user_id = Yii::$app->user->id;
                $model_client->change_date = $model->create_date;
                $model_client->save(false);
                $model->client_id = $model_client->id;
            }
            else{
                $model_client = new Client();
                $model_client->load(Yii::$app->request->post());
                $model_client->user_id = Yii::$app->user->id;
                $model_client->create_date = $model->create_date;
                $model_client->change_date = $model->create_date;
                $model_client->save(false);
                $model->client_id = $model_client->id;
            }

            if($model->save()){
                $client_id = $model->client_id;
                if(Yii::$app->request->post('pokaz')!==null){
                    foreach (Yii::$app->request->post('pokaz')[0] as $key => $value) {
                        $dopmodel = new RegDopinfo;
                        $dopmodel->reg_id = $model->id;
                        $dopmodel->indikator_id = $key;
                        $dopmodel->value = $value;
                        $dopmodel->save(false);
                    }
                }

                if(Yii::$app->request->post('analiz')!==NULL){
                    foreach(Yii::$app->request->post('analiz') as $key => $value) {
                        $analiz_id = trim($key,'\"');
                        $r_model = new RegAnalizs();
                        $r_model->analiz_id = $analiz_id;
                        $r_model->reg_id = $model->id;
                        $r_model->summa = SAnaliz::getPrice($analiz_id);
                        if($r_model->save()){
                            Reagent::minusCountForAnaliz($analiz_id,$model->id);
                        }
                        else{
                            var_dump($r_model->errors);die;
                        }
                    }
                }

                if(Yii::$app->request->post('reagent')!==NULL){
                    foreach(Yii::$app->request->post('reagent') as $key => $value) {
                        if($value>0){
                            Reagent::minusCount($key,$value,0,$model->id);     
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->errors);die;
            }
            
            
        }
        
        $groups = SGroups::find()->where(['active'=>1])->orderBy(['ord'=>SORT_ASC])->all();

        return $this->render('new', [
            'model' => $model,
            'model_client' => $model_client,
            'groups' => $groups,
        ]);
    }

    public function actionNew1()
    {
        if(Yii::$app->user->getRole()!=2&&Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $model = new Registration();
        $model_client = new Client();
        

        if ($model->load(Yii::$app->request->post())&&$model_client->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->natija_input = '0';
            // $model->sum_debt = $model->sum_amount-(int)$model->skidka_reg-(int)$model->skidka_kassa;
            $model->create_date = date("Y-m-d H:i:s");
            $model->change_time = $model->create_date;

            if($model_client_save = Client::getClientByDoc($model_client->doc_seria,$model_client->doc_number)){
                $model_client_save->lname = $model_client->lname;
                $model_client_save->fname = $model_client->fname;
                $model_client_save->mname = $model_client->mname;

                $model_client_save->add1 = $model_client->add1;
                $model_client_save->address_tuman = $model_client->address_tuman;
                $model_client_save->address_text = $model_client->address_text;

                $model_client_save->user_id = Yii::$app->user->id;
                $model_client_save->change_date = $model->create_date;
                if($model_client_save->save()){
                    $a = 1;
                }
                else{
                    var_dump($model_client_save->errors);die;
                }
                $model->client_id = $model_client_save->id;
            }
            elseif($model_client_save = Client::getClientByNameAndBirth($model_client->lname,$model_client->fname,$model_client->birthdate)){
                if(strlen($model_client->doc_seria)>0){
                    $model_client_save->doc_seria = $model_client->doc_seria;
                }
                if(strlen($model_client->doc_number)>0){
                    $model_client_save->doc_number = $model_client->doc_number;
                }
                $model_client_save->add1 = $model_client->add1;
                $model_client_save->address_tuman = $model_client->address_tuman;
                $model_client_save->address_text = $model_client->address_text;
                if($model_client_save->save()){
                    $a = 1;
                }
                else{
                    var_dump($model_client_save->errors);die;
                }
            }
            else{
                // $model_client = new Client();
                // $model_client->load(Yii::$app->request->post());
                $model_client->user_id = Yii::$app->user->id;
                $model_client->create_date = $model->create_date;
                $model_client->change_date = $model->create_date;
                if($model_client->save()){
                    $a = 1;
                }
                else{
                    var_dump($model_client->errors);die;
                }
                $model->client_id = $model_client->id;
            }

            if($model->save()){
                $client_id = $model->client_id;
                if(Yii::$app->request->post('pokaz')!==null){
                    foreach (Yii::$app->request->post('pokaz')[0] as $key => $value) {
                        $dopmodel = new RegDopinfo;
                        $dopmodel->reg_id = $model->id;
                        $dopmodel->indikator_id = $key;
                        $dopmodel->value = $value;
                        $dopmodel->save(false);
                    }
                }

                if(Yii::$app->request->post('analiz')!==NULL){
                    foreach(Yii::$app->request->post('analiz') as $key => $value) {
                        $analiz_id = trim($key,'\"');
                        $r_model = new RegAnalizs();
                        $r_model->analiz_id = $analiz_id;
                        $r_model->reg_id = $model->id;
                        $r_model->summa = SAnaliz::getPrice($analiz_id);
                        if($r_model->save()){
                        	Reagent::minusCountForAnaliz($analiz_id);
                        }
                        else{
                        	var_dump($r_model->errors);die;
                        }
                    }
                }

                if(Yii::$app->request->post('reagent')!==NULL){
                    // var_dump(Yii::$app->request->post('reagent'));die;
                    foreach(Yii::$app->request->post('reagent') as $key => $value) {
                        if($value>0){
                            Reagent::minusCount($key,$value,0);     
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                var_dump($model->errors);die;
            }
            
            
        }
        
        $groups = SGroups::find()->where(['active'=>1])->orderBy(['ord'=>SORT_ASC])->all();

        return $this->render('new1', [
            'model' => $model,
            'model_client' => $model_client,
            'groups' => $groups,
        ]);
    }

    public function actionLabqabul($id)
    {
        if(Yii::$app->user->getRole()!=4){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        $model->status = 3;
        if($model->save()){
            $this->sendRtimeSms($id);
            return $this->redirect(['indexlab']);
        }
        else{
            var_dump($model->errors);die;
        }
    }

    public function actionLabrad($id)
    {
        if(Yii::$app->user->getRole()!=4){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->sendRtimeSms($id);
            return $this->redirect(['indexlab']);
        }

        return $this->render('labrad', [
            'model' => $model,
        ]);
    }

    public function actionViewqr($group,$reg_id)
    {
        Yii::$app->response->format = 'pdf';
        $this->layout = '//print';
        


        $model = $this->findModel($reg_id);

        $analizs = RegAnalizs::getAnalizsByGroup($group,$reg_id);
        $check_chegara = 0;
        foreach ($analizs as $key => $value){
            Result::checkPokazs($reg_id,$value);
            if($value==252||$value==253||$value==134||$value==261||$value==250||$value==249){
                $check_chegara=1;
                $group = 'КОВИД';
            }
        }
            $searchModel = new ResultSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere(['main_id'=>$reg_id])->andWhere(['in','analiz_id',$analizs]);
            $dataProvider->pagination = ['pageSize' => 100];
        
        if($check_chegara==1){
            return $this->render('print_group_chegara', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'analizs' => $analizs,
                'group' => $group,
            ]);
        }
        else{
            return $this->render('test_chegara', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'analizs' => $analizs,
                'group' => $group,
            ]);
        }
        
    }


    public function actionUpdateAnalizs($id)
    {
        if(Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        

        return $this->render('update_analizs', [
            'model' => $model,
        ]);
    }

    public function actionInsertAnalizs($reg_id)
    {
        // echo "A";die;
        if(Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($reg_id);
        $sum = 0;
        if(Yii::$app->request->post('analiz')!==NULL){

            if(Reagent::regOtmen($reg_id)){
                foreach(Yii::$app->request->post('analiz') as $key => $value) {
                    $analiz_id = trim($key,'\"');
                    $r_model = new RegAnalizs();
                    $r_model->analiz_id = $analiz_id;
                    $r_model->reg_id = $model->id;
                    $r_model->summa = SAnaliz::getPrice($analiz_id);
                    $sum+=$r_model->summa;
                    if($r_model->save()){
                        Reagent::minusCountForAnaliz($analiz_id,$reg_id);
                    }
                    else{
                        var_dump($r_model->errors);die;
                    }
                }
                if(Yii::$app->request->post('pokaz')!==null){
                    foreach (Yii::$app->request->post('pokaz')[0] as $key => $value) {
                        $dopmodel = new RegDopinfo;
                        $dopmodel->reg_id = $model->id;
                        $dopmodel->indikator_id = $key;
                        $dopmodel->value = $value;
                        $dopmodel->save(false);
                    }
                }
                if(Yii::$app->request->post('reagent')!==NULL){
                    foreach(Yii::$app->request->post('reagent') as $key => $value) {
                        if($value>0){
                            Reagent::minusCount($key,$value,0,$reg_id);     
                        }
                    }
                }
            }
            $model->sum_amount = $sum;
            $model->change_time = date('Y-m-d H:i:s');
            if($model->save()){
                return $this->redirect('indexkassa');
            }
            else{
                var_dump($model->errors);die;
            }
            

            
        }
        
        $groups = SGroups::find()->where(['active'=>1])->orderBy(['ord'=>SORT_ASC])->all();

        return $this->render('insert_analizs', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    private function sendSmsByTemplate($text,$number)
    {
        $username = 'soglomtabassum';
        $password = '9x3A7c7FfS';
        $address = 'http://91.204.239.44/broker-api/send';
        $from = '3700';
        // $text = 'Test sms from Avaz.';
        // $number = '998974344466';
        $msg_id = 'soglomdi'.time();

        $body_json = '{"messages":[{"recipient":"'.$number.'","message-id":"'.$msg_id.'","sms":{"originator": "'.$from.'","content":{"text":"'.$text.'"}}}]}';

echo $body_json;
echo "<br>";

        // $body_json = json_encode($bodyData, JSON_UNESCAPED_UNICODE);
        $headers = [
            'Authorization: Basic ' . base64_encode( $username.':'.$password ),
            // 'accept: application/json',
            'content-type: application/json'
        ];
        var_dump($headers);
            echo "<br>";
        if($curl = curl_init()){
            curl_setopt($curl, CURLOPT_URL, 'http://91.204.239.44/broker-api/send');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body_json);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $out = curl_exec($curl);
            var_dump($out);
            echo "<br>";
            curl_close($curl);
            $data = json_decode($out);

            $sms_model = new SendSms();
            $sms_model->number = $number;
            $sms_model->sms_text = $text;
            $sms_model->send_date = date('Y-m-d H:i:s');
            $sms_model->save(false);
            // var_dump($data);die;   
        }
        return true;
    }

    public function actionUpdatelab($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['resultlab', 'id' => $model->id]);
        }

        return $this->render('updatelab', [
            'model' => $model,
        ]);
    }

    private function sendReadySms($id)
    {
        $model = $this->findModel($id);
        $template = SmsTemplates::find()->where(['code'=>'ready'])->one();
        if($template){
            $text = $template->sms_text;
        }
        else{
            $text = 'Hurmatli mijoz, Sog’lom diagnostikaga topshirgan tahlil natijangiz tayyorligini ma’lum qilamiz.';    
        }
        $number = Client::getPhonenumforsms($model->client_id);
        if($number&&$number!='998000000000'){
            $this->sendSmsByTemplate($text,$number);
        }
        else{
            return false;
        }        
    }

    private function sendRtimeSms($id)
    {
        $model = $this->findModel($id);
        $template = SmsTemplates::find()->where(['code'=>'rtime'])->one();
        if($template){
            $text = $template->sms_text;
        }
        else{
            $text = 'Hurmatli mijoz, Sog’lom diagnostikaga topshirgan tahlil natijalaringiz soat {rtime}da tayyor bo’ladi. Sizga hizmat ko’rsatayotganimizdan hursandmiz.';    
        }
        $text = str_replace('{rtime}', date('H:i d.m.Y',strtotime($model->lab_vaqt)), $text);

        $number = Client::getPhonenumforsms($model->client_id);
        if($number&&$number!='998000000000'){
            $this->sendSmsByTemplate($text,$number);
        }
        else{
            return false;
        }        
    }

    private function sendKassaSms($id)
    {
        $model = $this->findModel($id);
        $template = SmsTemplates::find()->where(['code'=>'kassa'])->one();
        if($template){
            $text = $template->sms_text;
        }
        else{
            $text = 'Assalomu alaykum Hurmatli mijoz, Sog’lom diagnostikaga tibbiy tahlil uchun {summa} to’ladingiz. {qarz}Bizni tanlaganingiz uchun rahmat.';   
        }
        if($model){
            $sum = $model->sum_cash+$model->sum_plastik;
            $summa = $sum.' so’m';
            

            if($model->sum_debt!=NULL&&$model->sum_debt!=0){
                $qarz = 'Qarzingiz: '.$model->sum_debt.' so’m. ';
            }
            else{
                $qarz = '';
            }
        }
        $filial_id = Users::getFilial($model->user_id);
        if($filial_id){
            $filtel = Filials::getPhone($filial_id);    
        }
        else{
            $filtel = '';
        }
        

        $text = str_replace('{summa}', $summa, $text);
        $text = str_replace('{qarz}', $qarz, $text);
        $text = str_replace('{filtel}', $filtel, $text);

        $number = Client::getPhonenumforsms($model->client_id);
        if($number&&$number!='998000000000'){
            $this->sendSmsByTemplate($text,$number);
        }
        else{
            return false;
        }        
    }

    public function actionTestphone($id)
    {
        var_dump($this->sendKassaSms($id));
        die;
    }
    
}
