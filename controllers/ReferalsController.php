<?php

namespace app\controllers;

use Yii;
use app\models\Referals;
use app\models\ReferalsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Registration;
use app\models\RefSends;
use app\models\Rasxod;
use app\models\Users;
/**
 * ReferalsController implements the CRUD actions for Referals model.
 */
class ReferalsController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Referals models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReferalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==4||Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==9){
            return $this->render('index_admin', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        else{
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
    }

    /**
     * Displays a single Referals model.
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
     * Creates a new Referals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Referals();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Referals model.
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
     * Deletes an existing Referals model.
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
     * Finds the Referals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Referals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Referals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionHisob($id)
    {
        $model = $this->findModel($id);
        $sum = 0;
        

        if($model->id!=131){
            if($model->last_change_date!==true){
                $model->last_change_date = "2021-01-01 00:00:01";
            }
            $rs_model = RefSends::find()->where(['refnum'=>$model->refnum])->orderBy(['send_date'=>SORT_DESC])->one();
            if($rs_model){
               $model->last_change_date = $rs_model->send_date; 
            }
            else{
                $model->last_change_date = "2021-01-01 00:00:01";
            }
            if($model->add1>0){
                $regs = Registration::find()
                ->select('sum(IFNULL(sum_cash, 0))+sum(IFNULL(sum_plastik, 0)) AS `s_amount`')
                ->where(['>','create_date',$model->last_change_date])
                ->andWhere(['ref_code'=>$model->refnum])
                ->andWhere(['skidka_reg'=>null])
                ->asArray()
                ->all();
                if($regs[0]['s_amount']){
                    $sum = $regs[0]['s_amount']*(int)$model->add1/100;
                }
                else{
                    $sum = 0;
                }
            }
            else{
                $regs = Registration::find()
                    ->where(['>','create_date',$model->last_change_date])
                    ->andWhere(['ref_code'=>$model->refnum])
                    ->andWhere(['OR',['>','sum_cash',0],['>','sum_plastik',0]])
                    ->andWhere(['skidka_reg'=>null])
                    ->asArray()
                    ->count();
                $sum = (int)$regs*$model->fix_sum;
            }
            
            $model->qoldiq_summa = (int)$sum;//(int)$model->qoldiq_summa + 

        }

        $model->last_change_date = date("Y-m-d H:i:s");

        if($model->save()){
            return $this->redirect(['index', 'ReferalsSearch[refnum]'=>$model->refnum]);
        }
        else{
            var_dump($model->errors);;
        }

        
    }

    public function actionSend($id,$type)
    {
        $model = $this->findModel($id);

        $rs_model = new RefSends();
        $rs_model->refnum = $model->refnum;
        $rs_model->sum = $model->qoldiq_summa;
        $rs_model->status = 1;
        $rs_model->send_type = $type;
        $rs_model->user_id = Yii::$app->user->id;
        $rs_model->send_date = date("Y-m-d H:i:s");

        if($rs_model->save()){
            $rasxod_model = new Rasxod();
            $rasxod_model->filial_id = $model->filial;
            $rasxod_model->user_id = $rs_model->user_id;
            $rasxod_model->summa = $rs_model->sum;
            $rasxod_model->sum_type = $rs_model->send_type;
            $rasxod_model->rasxod_type = 1; //referallarga tolovlar
            $rasxod_model->rasxod_desc = $rs_model->refnum.' referalga avtomatik yaratilgan to\'lov.';
            $rasxod_model->rasxod_period = date('Y-m').'-01';
            $rasxod_model->create_date = date('Y-m-d H:i:s');
            $rasxod_model->status = 1; // yuborildi


            $user = Users::find()->where(['add1'=>$model->filial,'role_id'=>3])->one();
            // var_dump($user);die;
            if($user){
                $rasxod_model->send_user = $user->id; //qaysi hodim javobgar
            }
            else{
                $rasxod_model->send_user = 1; //qaysi hodim javobgar    
            }
            
            $rasxod_model->referal_id = $rs_model->refnum;

            if($rasxod_model->save()){
                $model->qoldiq_summa = 0;
                if($model->save()){
                    return $this->redirect(['index', 'ReferalsSearch[refnum]'=>$model->refnum]);
                }
                else{
                    var_dump($model->errors);
                }
            }
            else{
                var_dump($rasxod_model->errors);die;
            }
        }
        else{
            var_dump($rs_model->errors);
        }
    }
}
