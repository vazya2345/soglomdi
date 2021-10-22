<?php

namespace app\controllers;

use Yii;
use app\models\MoneySend;
use app\models\FilialQoldiq;
use app\models\MoneySendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MoneySendController implements the CRUD actions for MoneySend model.
 */
class MoneySendController extends Controller
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
     * Lists all MoneySend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoneySendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query
            ->andWhere(['send_user'=>Yii::$app->user->id])
            ->orWhere(['rec_user'=>Yii::$app->user->id])
            ->orderBy(['id'=>SORT_DESC]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MoneySend model.
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
     * Creates a new MoneySend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MoneySend();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MoneySend model.
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
     * Deletes an existing MoneySend model.
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
     * Finds the MoneySend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneySend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneySend::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionQabul($id)
    {
        $model = $this->findModel($id);
        $fq_model = FilialQoldiq::find()->where(['kassir_id'=>$model->rec_user,'qoldiq_type'=>$model->send_type])->one();

        $sender_fq_model = FilialQoldiq::find()->where(['kassir_id'=>$model->send_user,'qoldiq_type'=>$model->send_type])->one();


        if($sender_fq_model->qoldiq>=$model->amount){
            $model->status = 2;
            $model->rec_date = date("Y-m-d H:i:s");

            $fq_model->qoldiq += $model->amount;
            $fq_model->last_change_date = $model->rec_date;


            $sender_fq_model->qoldiq -= $model->amount;
            $sender_fq_model->last_change_date = $model->rec_date;

            if($fq_model->save()&&$model->save()&&$sender_fq_model->save()){
                return $this->redirect(['index']);
            }
            else{
                var_dump($fq_model->errors);
                var_dump($model->errors);
                var_dump($sender_fq_model->errors);
            }        
        }
        else{
            echo "Кассада етарли маблағ мавжуд эмас.";die;
        }

        
    }


    public function actionRad($id)
    {
        $model = $this->findModel($id);
        
        $model->status = 3;

        if($model->save()){
            return $this->redirect(['index']);
        }
        else{
            var_dump($model->errors);
        }        
    }
}
