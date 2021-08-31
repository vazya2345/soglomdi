<?php

namespace app\controllers;

use Yii;
use app\models\ReagentInput;
use app\models\ReagentInputSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Reagent;
use app\models\ReagentNotifications;

/**
 * ReagentInputController implements the CRUD actions for ReagentInput model.
 */
class ReagentInputController extends Controller
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
     * Lists all ReagentInput models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReagentInputSearch();
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
     * Displays a single ReagentInput model.
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
     * Creates a new ReagentInput model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReagentInput();

        if ($model->load(Yii::$app->request->post())) {
            $model->create_date = date("Y-m-d H:i:s");
            $model->user_id = Yii::$app->user->id;
            if($model->save()){
                $rmodel = Reagent::findOne($model->reagent_id);
                $rmodel->qoldiq += $model->value;
                if(strlen(Yii::$app->request->post('narxyangi'))>0){
                    $rmodel->price = Yii::$app->request->post('narxyangi');
                }
                if($rmodel->save()){
                    $notifs = ReagentNotifications::find()->where(['reagent_id'=>$model->reagent_id])->all();
                    foreach ($notifs as $notif) {
                        $notif->delete(); 
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{
                    var_dump($rmodel->errors);die;
                }    
            }
            else{
                var_dump($model->errors);die;
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReagentInput model.
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
     * Deletes an existing ReagentInput model.
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
     * Finds the ReagentInput model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReagentInput the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReagentInput::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
