<?php

namespace app\controllers;

use Yii;
use app\models\QarzQaytar;
use app\models\Registration;
use app\models\Payments;
use app\models\FinishPayments;
use app\models\FilialQoldiq;
use app\models\QarzQaytarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FqSendsController implements the CRUD actions for FqSends model.
 */
class QarzQaytarController extends Controller
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
     * Lists all FqSends models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FqSendsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FqSends model.
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
     * Creates a new FqSends model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FqSends();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FqSends model.
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
     * Deletes an existing FqSends model.
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
     * Finds the FqSends model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FqSends the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = QarzQaytar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSave($id)
    {
        if(Yii::$app->user->getRole()!=3){
            return $this->redirect(['site/index']);
        }
        $qarz_model = $this->findModel($id);

        if ($qarz_model->load(Yii::$app->request->post())) {
            $qarz_model->kassir_id = Yii::$app->user->id;
            $qarz_model->qaytargan_vaqt = date("Y-m-d H:i:s");
            if($qarz_model->save()){
                $reg_model = Registration::findOne($qarz_model->reg_id);
                $reg_model->sum_cash+=(int)$qarz_model->summa_naqd;
                $reg_model->sum_plastik+=(int)$qarz_model->summa_plasitk;
                $reg_model->sum_debt=$reg_model->sum_debt-((int)$qarz_model->summa_plasitk+(int)$qarz_model->summa_naqd);
                if($reg_model->sum_debt<0){
                    $reg_model->sum_debt = 0;
                }
                if(($reg_model->sum_cash+$reg_model->sum_plastik)>$reg_model->sum_amount){
                    $reg_model->sum_cash-=(int)$qarz_model->summa_naqd;
                    $reg_model->sum_plastik-=(int)$qarz_model->summa_plasitk;
                }



                










                if($reg_model->save()){
                    $s1 = (int)$reg_model->sum_amount;
                    $s2 = (int)$reg_model->sum_cash+(int)$reg_model->sum_plastik+(int)$reg_model->skidka_reg+(int)$reg_model->skidka_kassa;
                    $payment_model = new Payments();
                    $payment_model->main_id = $qarz_model->reg_id;
                    $payment_model->kassir_id = Yii::$app->user->id;
                    $payment_model->cash_sum = (int)$qarz_model->summa_naqd;
                    $payment_model->plastik_sum = (int)$qarz_model->summa_plasitk;
                    $payment_model->create_date = date("Y-m-d H:i:s");

//check double payment
                    $cp_model = Payments::find()->where(['main_id'=>$id])->andWhere(['between', 'create_date', date("Y-m-d H:i:s", strtotime($payment_model->create_date)-120), date("Y-m-d H:i:s", strtotime($payment_model->create_date)+120)])->one();
                    if(!$cp_model){
                        if($payment_model->save()){
                            FilialQoldiq::hisobAllTypesByKassirId($payment_model->kassir_id);
                            if($s1<=$s2){
                                $fmodel = new FinishPayments();
                                $fmodel->id = $reg_model->id;
                                $fmodel->time = date("Y-m-d H:i:s");
                                $fmodel->user_id = Yii::$app->user->id;
                                if($fmodel->save()){
                                    // $this->sendKassaSms($id);
                                    return $this->redirect(['registration/indexkassa']);
                                }
                                else{
                                    echo "1-"; var_dump($fmodel->errors);die;
                                }
                            }
                        }
                        else{
                            echo "2-"; var_dump($payment_model->errors);die;
                        }
                    }
                    else{
                        echo "Тўлов икки марта ўтиб кетиш хавфи пайдо бўлди.";die;
                    }
/////////


                }
                else{
                    echo "3-"; var_dump($reg_model->errors);die;
                }
            }
            else{
                return $this->redirect(['registration/indexkassa']);
            }
        }
        else{
            return $this->redirect(['site/index']);
        }
    }
}
