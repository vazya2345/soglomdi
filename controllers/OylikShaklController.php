<?php

namespace app\controllers;

use Yii;
use app\models\OylikShakl;
use app\models\OylikShaklSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\models\OylikHodimlar;
use app\models\OylikPeriods;
use app\models\OylikUderj;
use app\models\OylikUderjSearch;
use app\models\OylikUderjTypes;
use app\models\Filials;
use app\models\Rasxod;
use app\models\Users;
/**
 * OylikShaklController implements the CRUD actions for OylikShakl model.
 */
class OylikShaklController extends Controller
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
     * Lists all OylikShakl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OylikUderjSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where([
            'status' => 2
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['period' => SORT_DESC, 'id'=>SORT_DESC],
        ]);
        // $dataProvider->query
        //     ->orderBy(['id'=>SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);



        // $searchModel = new OylikShaklSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->setSort([
        //     'defaultOrder' => ['period' => SORT_DESC, 'shakl_id'=>SORT_ASC],
        // ]);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

    }

    /**
     * Displays a single OylikShakl model.
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
     * Creates a new OylikShakl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OylikShakl();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OylikShakl model.
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
     * Deletes an existing OylikShakl model.
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
     * Finds the OylikShakl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OylikShakl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OylikShakl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionShakllantirish()
    {
        $i=0;
        $period = OylikPeriods::getActivePeriod();
        $model = OylikUderj::find()->where(['period'=>$period, 'title' => '4'])->one();
        if($model){
            return $this->redirect(['index']);
        }

        $hodimlar = OylikHodimlar::find()->all();
        foreach ($hodimlar as $hodim) {
                $uderjsum = 0;
                $uderjs = OylikUderj::find()->where(['oylik_hodimlar_id'=>$hodim->id, 'period'=>$period])->all();
                foreach ($uderjs as $uderj) {
                    if($uderj->status==1){
                        $uderj->status = 3;
                        if($uderj->save()){
                            $rasxod_model = Rasxod::find()->where(['oylik_uderj_id'=>$uderj->id, 'status' => 1])->one();
                            if($rasxod_model){
                                $rasxod_model->status = 3;
                                if($rasxod_model->save()){
                                    continue;
                                }
                            }
                        }

                        if(!OylikUderjTypes::getIsRasxod($uderj->title)){
                            $uderjsum+=$uderj->summa;
                        }
                    }
                    elseif($uderj->status==2){
                        $uderjsum+=$uderj->summa;
                    }
                    else{
                        $i++;
                    }

                }





                if($this->uderjYozish($period, $hodim, '4', round($hodim->summa-$uderjsum))){
                    $i++;
                }
        }



        return $this->redirect(['index']);
    }


    public function actionAvans()
    {
        $i=0;
        $period = OylikPeriods::getActivePeriod();
        $model = OylikUderj::find()->where(['period'=>$period, 'title' => '1'])->one();
        if($model){
            return $this->redirect(['index']);
        }
        else{
            $hodimlar = OylikHodimlar::find()->where(['other_info'=>'1'])->all();
            foreach ($hodimlar as $hodim) {
                if($this->uderjYozish($period, $hodim, '1', round($hodim->summa*0.4))){
                    $i++;
                }
            }
            return $this->redirect(['index']);
        }
        
    }


    protected function uderjYozish($period, $hodim, $type, $summa)
    {
        $umodel = new OylikUderj();
        $umodel->oylik_hodimlar_id = $hodim->id;
        $umodel->title = $type;
        $umodel->summa = $summa;
        $umodel->status = 1;
        $umodel->period = $period;
        $umodel->create_date = date("Y-m-d H:i:s");
        $umodel->create_userid = Yii::$app->user->id;
        if($umodel->save()){
                $rasxod_model = new Rasxod();
                $rasxod_model->filial_id = 1;
                $rasxod_model->user_id = Users::getZavkassa();
                $rasxod_model->summa = $umodel->summa;
                $rasxod_model->sum_type = 1;
                $rasxod_model->rasxod_type = 5;
                $rasxod_model->rasxod_desc = OylikHodimlar::getName($umodel->oylik_hodimlar_id).'ga oylik hisobidan avtomatik yaratilgan to‘lov '.OylikUderjTypes::getName($umodel->title); /////
                $rasxod_model->rasxod_period = OylikPeriods::getActivePeriod();
                $rasxod_model->status = 1;
                $rasxod_model->create_date = date("Y-m-d H:i:s");
                $rasxod_model->mod_date = date("Y-m-d H:i:s");

                $rasxod_model->oylik_uderj_id = $umodel->id;
                
                if($rasxod_model->save()){
                    return true;
                }
                else{
                    return false;
                }
        }
        else{
            return false;
        }    
    }




}
