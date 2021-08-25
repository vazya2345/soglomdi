<?php

namespace app\controllers;

use Yii;
use app\models\Registration;
use app\models\Client;
use app\models\RegDopinfo;
use app\models\Result;
use app\models\SAnaliz;
use app\models\SGroups;
use app\models\ResultSearch;
use app\models\RegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\FinishPayments;

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
        if(Yii::$app->user->getRole()==3){
            return $this->redirect(['indexkassa']);
        }
        elseif(Yii::$app->user->getRole()==4||Yii::$app->user->getRole()==5){
            return $this->redirect(['indexlab']);
        }
        else{
            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
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
        else{
            $searchModel = new RegistrationSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->setSort([
                'defaultOrder' => ['id'=>SORT_DESC],
            ]);
            return $this->render('indexkassa', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionIndexlab()
    {
        if(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==2){
            return $this->redirect(['index']);
        }
        elseif(Yii::$app->user->getRole()==3){
            return $this->redirect(['indexkassa']);
        }
        $searchModel = new RegistrationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['id'=>SORT_DESC],
        ]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $s1 = (int)$model->sum_amount;
            $s2 = (int)$model->sum_cash+(int)$model->sum_plastik;
            if($s1<=$s2){
                $fmodel = new FinishPayments();
                $fmodel->id = $id;
                $fmodel->time = date("Y-m-d H:i:s");
                $fmodel->user_id = Yii::$app->user->id;
                $fmodel->save(false);
            }
            return $this->redirect(['indexkassa']);
        }

        return $this->render('kassatulov', [
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
        if(Yii::$app->user->getRole()!=2){
            return $this->redirect(['index']);
        }
        $model = new Registration();
        $model_client = new Client();
        
        // print_r(Yii::$app->request->post());die;
        if ($model->load(Yii::$app->request->post())&&$model_client->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->add2 = 0;
            $model->create_date = date("Y-m-d H:i:s");
            $model->change_time = date("Y-m-d H:i:s");

            if($model_client1 = Client::getClientByDoc($model_client->doc_seria,$model_client->doc_number)){
                $model_client1->fname = $model_client->fname;
                $model_client1->lname = $model_client->lname;
                $model_client1->mname = $model_client->mname;
                $model_client1->birthdate = $model_client->birthdate;
                $model_client1->sex = $model_client->sex;
                $model_client1->user_id = Yii::$app->user->id;
                $model_client1->change_date = date("Y-m-d H:i:s");
                $model_client1->save(false);
                $model->client_id = $model_client1->id;
            }
            else{
                $model_client->user_id = Yii::$app->user->id;
                $model_client->create_date = date("Y-m-d H:i:s");
                $model_client->change_date = date("Y-m-d H:i:s");
                $model_client->save(false);
                $model->client_id = $model_client->id;
            }

            if($model->save()){
                $client_id = $model->client_id;
                $add1 = $model->add1;
                if(Yii::$app->request->post('pokaz')!==null){
                    foreach (Yii::$app->request->post('pokaz')[0] as $key => $value) {
                        $dopmodel = new RegDopinfo;
                        $dopmodel->reg_id = $model->id;
                        $dopmodel->indikator_id = $key;
                        $dopmodel->value = $value;
                        $dopmodel->save(false);
                    }
                }

                if(Yii::$app->request->post('regs')!==NULL){
                    foreach (Yii::$app->request->post('regs') as $key => $value) {
                        $r_model = new Registration();
                        $r_model->analiz_id = $value['analiz_id'];
                        $r_model->sum_amount = $value['sum_amount'];
                        $r_model->client_id = $client_id;
                        $r_model->add1 = $add1;
                        $r_model->user_id = Yii::$app->user->id;
                        $r_model->create_date = date("Y-m-d H:i:s");
                        $r_model->change_time = date("Y-m-d H:i:s");
                        if($r_model->save()){
                            if(Yii::$app->request->post('pokaz')[$key]!==null){
                                foreach (Yii::$app->request->post('pokaz')[$key] as $key1 => $value1) {
                                    $dopmodel = new RegDopinfo;
                                    $dopmodel->reg_id = $r_model->id;
                                    $dopmodel->indikator_id = $key1;
                                    $dopmodel->value = $value1;
                                    $dopmodel->save(false);
                                }
                            }
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            
            
        }

        return $this->render('create', [
            'model' => $model,
            'model_client' => $model_client,
        ]);
    }

    public function actionNew()
    {
        if(Yii::$app->user->getRole()!=2){
            return $this->redirect(['index']);
        }
        $model = new Registration();
        $model_client = new Client();
        
        if($model->load(Yii::$app->request->post())){
            print_r(Yii::$app->request->post());die;
        }
        if ($model->load(Yii::$app->request->post())&&$model_client->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->add2 = 0;
            $model->create_date = date("Y-m-d H:i:s");
            $model->change_time = date("Y-m-d H:i:s");

            if($model_client1 = Client::getClientByDoc($model_client->doc_seria,$model_client->doc_number)){
                $model_client1->fname = $model_client->fname;
                $model_client1->lname = $model_client->lname;
                $model_client1->mname = $model_client->mname;
                $model_client1->birthdate = $model_client->birthdate;
                $model_client1->sex = $model_client->sex;
                $model_client1->user_id = Yii::$app->user->id;
                $model_client1->change_date = date("Y-m-d H:i:s");
                $model_client1->save(false);
                $model->client_id = $model_client1->id;
            }
            else{
                $model_client->user_id = Yii::$app->user->id;
                $model_client->create_date = date("Y-m-d H:i:s");
                $model_client->change_date = date("Y-m-d H:i:s");
                $model_client->save(false);
                $model->client_id = $model_client->id;
            }

            if($model->save()){
                $client_id = $model->client_id;
                $add1 = $model->add1;
                if(Yii::$app->request->post('pokaz')!==null){
                    foreach (Yii::$app->request->post('pokaz')[0] as $key => $value) {
                        $dopmodel = new RegDopinfo;
                        $dopmodel->reg_id = $model->id;
                        $dopmodel->indikator_id = $key;
                        $dopmodel->value = $value;
                        $dopmodel->save(false);
                    }
                }

                if(Yii::$app->request->post('regs')!==NULL){
                    foreach (Yii::$app->request->post('regs') as $key => $value) {
                        $r_model = new Registration();
                        $r_model->analiz_id = $value['analiz_id'];
                        $r_model->sum_amount = $value['sum_amount'];
                        $r_model->client_id = $client_id;
                        $r_model->add1 = $add1;
                        $r_model->user_id = Yii::$app->user->id;
                        $r_model->create_date = date("Y-m-d H:i:s");
                        $r_model->change_time = date("Y-m-d H:i:s");
                        if($r_model->save()){
                            if(Yii::$app->request->post('pokaz')[$key]!==null){
                                foreach (Yii::$app->request->post('pokaz')[$key] as $key1 => $value1) {
                                    $dopmodel = new RegDopinfo;
                                    $dopmodel->reg_id = $r_model->id;
                                    $dopmodel->indikator_id = $key1;
                                    $dopmodel->value = $value1;
                                    $dopmodel->save(false);
                                }
                            }
                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            
            
        }
        
        $groups = SGroups::find()->where(['active'=>1])->all();

        return $this->render('new', [
            'model' => $model,
            'model_client' => $model_client,
            'groups' => $groups,
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
        if(Registration::getIsPay($id)&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==2)){
            $model = $this->findModel($id);
            Result::checkPokazs($model);
            $searchModel = new ResultSearch();
            $_GET['ResultSearch']['main_id']=$id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination = ['pageSize' => 100];
            $i=1;
            if($i==1){
                return $this->render('result_view', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
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

    public function actionPrint($id)
    {
        Yii::$app->response->format = 'pdf';
        $this->layout = '//print';
        $model = $this->findModel($id);
        Result::checkPokazs($model);
        $searchModel = new ResultSearch();
        $_GET['ResultSearch']['main_id']=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 100];
        $i=1;
        if($i==1){
            return $this->render('print', [
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return;    
        }
        
    }

    public function actionResultlab($id)
    {
        if(Yii::$app->user->getRole()!=4){
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        Result::checkPokazs($model);
        $searchModel = new ResultSearch();
        $_GET['ResultSearch']['main_id']=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 100];
        $fmodel = FinishPayments::findOne($model->id);
        
        return $this->render('resultlab', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);    
    
        
    }

    public function actionSave($id)
    {
        $pokazs = Yii::$app->request->post('pokaz');
        foreach ($pokazs as $pokaz => $value) {
            $model = Result::findOne($pokaz);
            $model->reslut_value = $value;
            $model->user_id = Yii::$app->user->id;
            $model->create_date = date("Y-m-d H:i:s");
            $model->save(false);
        }
        $model = $this->findModel($id);
        $model->add2 = 1;
        $model->save(false);
        // echo "A";die;
        return $this->redirect(['resultsaved', 'id' => $id]);
        // return $this->redirect(['index']);
    }

    public function actionResultsaved($id)
    {
        return $this->render('result_saved');
    }
}
