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

        if(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==4||Yii::$app->user->getRole()==6){
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
        $sum = 0;
        $model = $this->findModel($id);

        if($model->id!=131){
            if(strlen($model->last_change_date)==0){
                $model->last_change_date = "2021-01-01 00:00:01";
            }
            $regs = Registration::find()->select('sum(IFNULL(sum_amount, 0))-sum(IFNULL(skidka_reg, 0))-sum(IFNULL(skidka_kassa, 0)) AS `s_amount`')->where(['>','create_date',$model->last_change_date])->andWhere(['ref_code'=>$model->refnum])->asArray()->all();
            // var_dump($regs);die;

            if($regs[0]['s_amount']){
                $sum = $regs[0]['s_amount']*(int)$model->add1/100;
            }
            else{
                $sum = 0;    
            }
            $model->qoldiq_summa = (int)$model->qoldiq_summa + (int)$sum;

        }

        $model->last_change_date = date("Y-m-d H:i:s");

        if($model->save()){
            return $this->redirect(['index', 'ReferalsSearch[refnum]'=>$model->refnum]);
        }
        else{
            var_dump($model->errors);;
        }

        
    }

    public function actionSend($id)
    {
        $model = $this->findModel($id);

        $rs_model = new RefSends();
        $rs_model->refnum = $model->refnum;
        $rs_model->sum = $model->qoldiq_summa;
        $rs_model->status = 1;
        $rs_model->user_id = Yii::$app->user->id;
        $rs_model->send_date = date("Y-m-d H:i:s");

        if($rs_model->save()){
            $model->qoldiq_summa = 0;
            if($model->save()){
                return $this->redirect(['index', 'ReferalsSearch[refnum]'=>$model->refnum]);
            }
            else{
                var_dump($model->errors);;
            }
        }
        else{
            var_dump($rs_model->errors);;
        }
    }
}
