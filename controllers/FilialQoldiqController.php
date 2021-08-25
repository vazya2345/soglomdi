<?php

namespace app\controllers;

use Yii;
use app\models\FilialQoldiq;
use app\models\Registration;
use app\models\QarzQaytar;
use app\models\FqSends;
use app\models\Payments;
use app\models\FilialQoldiqSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FilialQoldiqController implements the CRUD actions for FilialQoldiq model.
 */
class FilialQoldiqController extends Controller
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
     * Lists all FilialQoldiq models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->getRole()==3){
            return $this->redirect(['indexkassa']);
        }
        $searchModel = new FilialQoldiqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexkassa()
    {
        if(Yii::$app->user->getRole()!=3){
            return $this->redirect(['index']);
        }
        $searchModel = new FilialQoldiqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['kassir_id'=>Yii::$app->user->id]);

        return $this->render('indexkassa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FilialQoldiq model.
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
     * Creates a new FilialQoldiq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FilialQoldiq();

        if ($model->load(Yii::$app->request->post())) {
            $model->last_change_date = date('Y-m-d H:i:s');
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);    
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FilialQoldiq model.
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
     * Deletes an existing FilialQoldiq model.
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
     * Finds the FilialQoldiq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FilialQoldiq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FilialQoldiq::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionHisob($id)
    {
        $sum = 0;
        $model = $this->findModel($id);
        if($model->id!=8){
            $regs = Payments::find()->select('sum(IFNULL(cash_sum, 0))+sum(IFNULL(plastik_sum, 0)) AS `s_amount`')->where(['>','create_date',$model->last_change_date])->andWhere(['kassir_id'=>$model->kassir_id])->asArray()->all();
            if($regs[0]['s_amount']){
                $sum = $regs[0]['s_amount'];
            }
            else{
                $sum = 0;    
            }
            $model->qoldiq = (int)$model->qoldiq + (int)$sum;

        }
        else{
            $regs = FqSends::find()->select('sum(IFNULL(sum, 0)) AS `s_amount`')->where(['>','rec_date',$model->last_change_date])->andWhere(['status'=>2])->andWhere(['<>','fq_id',8])->asArray()->all();
            if($regs[0]['s_amount']){
                $sum = $regs[0]['s_amount'];
            }
            else{
                $sum = 0;    
            }
            $model->qoldiq = (int)$model->qoldiq + (int)$sum;
        }

        $model->last_change_date = date("Y-m-d H:i:s");
        if($model->save()){
            return $this->redirect(['index']);
        }
        else{
            var_dump($model->errors);;
        }

        
    }

    public function actionSend($id)
    {
        $model = $this->findModel($id);

        $fq_model = new FqSends();
        $fq_model->fq_id = $id;
        $fq_model->sum = $model->qoldiq;
        $fq_model->status = 1;
        $fq_model->send_date = date("Y-m-d H:i:s");

        if($fq_model->save()){
            $model->qoldiq = 0;
            if($model->save()){
                return $this->redirect(['index']);
            }
            else{
                var_dump($model->errors);;
            }
        }
        else{
            var_dump($fq_model->errors);;
        }        
    }
}
