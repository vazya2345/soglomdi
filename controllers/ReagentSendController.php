<?php

namespace app\controllers;

use Yii;
use app\models\ReagentSend;
use app\models\ReagentSendSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ReagentFilial;
use app\models\Reagent;
use app\models\ReagentNotifications;
/**
 * ReagentSendController implements the CRUD actions for ReagentSend model.
 */
class ReagentSendController extends Controller
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
     * Lists all ReagentSend models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReagentSendSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['id'=>SORT_DESC],
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReagentSend model.
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
     * Creates a new ReagentSend model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReagentSend();

        if ($model->load(Yii::$app->request->post())) {
            $model->send_date = date("Y-m-d H:i:s");

            $reagent_model = Reagent::findOne($model->reagent_id);

            if($reagent_model->qoldiq>=$model->soni){
                $rfmodel = ReagentFilial::find()->where(['filial_id'=>$model->filial_id,'reagent_id'=>$model->reagent_id])->one();
                if($rfmodel){
                    $rfmodel->qoldiq+=$model->soni;
                }
                else{
                    $rfmodel = new ReagentFilial();
                    $rfmodel->filial_id = $model->filial_id;
                    $rfmodel->reagent_id = $model->reagent_id;
                    $rfmodel->qoldiq = $model->soni;
                }

                $reagent_model->qoldiq = $reagent_model->qoldiq-$model->soni;

                if($rfmodel->save()&&$model->save()&&$reagent_model->save()){    
                    if($reagent_model->qoldiq<$reagent_model->notific_count){
                                $notif_model = new ReagentNotifications();
                                $notif_model->reagent_id = $reagent_model->id;
                                $notif_model->create_date = date("Y-m-d H:i:s");
                                $notif_model->filial_id = 777; //// FILIAL
                                if(!$notif_model->save()){
                                    var_dump($notif_model);die;
                                }
                    }
                    $notifs = ReagentNotifications::find()->where(['reagent_id'=>$model->reagent_id,'filial_id'=>$model->filial_id])->all();
                    foreach ($notifs as $notif) {
                        $notif->delete(); 
                    }
                }
                else{
                    var_dump($rfmodel->errors);die;
                }
                return $this->redirect(['view', 'id' => $model->id]);    
            }
            else{
                die('Бунча реагент складда мавжуд эмас.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReagentSend model.
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
     * Deletes an existing ReagentSend model.
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
     * Finds the ReagentSend model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReagentSend the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReagentSend::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
