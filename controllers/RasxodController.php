<?php

namespace app\controllers;

use Yii;
use app\models\Rasxod;
use app\models\FilialQoldiq;
use app\models\RasxodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RasxodController implements the CRUD actions for Rasxod model.
 */
class RasxodController extends Controller
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
     * Lists all Rasxod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RasxodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->user->getRole()!=1){
            $dataProvider->query
            ->andWhere(['user_id'=>Yii::$app->user->id])
            ->orderBy(['id'=>SORT_DESC]);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rasxod model.
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
     * Creates a new Rasxod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rasxod();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            if($model->save()){
                $fq_model = FilialQoldiq::find()->where(['kassir_id'=>Yii::$app->user->id,'qoldiq_type'=>$model->sum_type])->one();

                $fq_model->qoldiq -= $model->summa;
                $fq_model->last_change_date = date("Y-m-d H:i:s");

                if($fq_model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    var_dump($fq_model->errors);die;
                }    
            }
            


            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rasxod model.
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
     * Deletes an existing Rasxod model.
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
     * Finds the Rasxod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rasxod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rasxod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
