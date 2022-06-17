<?php

namespace app\controllers;

use Yii;
use app\models\OylikUderj;
use app\models\OylikUderjSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Rasxod;

use app\models\OylikHodimlar;
use app\models\OylikPeriods;
use app\models\OylikUderjTypes;


/**
 * OylikUderjController implements the CRUD actions for OylikUderj model.
 */
class OylikUderjController extends Controller
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
     * Lists all OylikUderj models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OylikUderjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query
            ->orderBy(['id'=>SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OylikUderj model.
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
     * Creates a new OylikUderj model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OylikUderj();

        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model);die;
            $model->create_date = date("Y-m-d H:i:s");
            $model->create_userid = Yii::$app->user->id;
            $model->status = 1;
            
            if($model->save()){
                $oylik_uderjtype_model = OylikUderjTypes::findOne($model->title);
                if($oylik_uderjtype_model){
                    if($oylik_uderjtype_model->is_rasxod==1){
                        $rasxod_model = new Rasxod();
                        $rasxod_model->filial_id = 1;
                        $rasxod_model->user_id = Yii::$app->user->id;
                        $rasxod_model->summa = $model->summa;
                        $rasxod_model->sum_type = 1;
                        $rasxod_model->rasxod_type = 5;
                        $rasxod_model->rasxod_desc = OylikHodimlar::getName($model->oylik_hodimlar_id).'ga oylik hisobidan avtomatik yaratilgan to‘lov '.OylikUderjTypes::getName($model->title); /////
                        $rasxod_model->rasxod_period = OylikPeriods::getActivePeriod();
                        $rasxod_model->status = 1;
                        $rasxod_model->create_date = date("Y-m-d H:i:s");
                        $rasxod_model->mod_date = date("Y-m-d H:i:s");

                        $rasxod_model->oylik_uderj_id = $model->id;
                        $rasxod_model->save(false);       
                    }
                }
                
                return $this->redirect(['view', 'id' => $model->id]);    
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OylikUderj model.
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
     * Deletes an existing OylikUderj model.
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
     * Finds the OylikUderj model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OylikUderj the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OylikUderj::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
