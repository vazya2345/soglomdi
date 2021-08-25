<?php

namespace app\controllers;

use Yii;
use app\models\PokazLimits;
use app\models\SPokazatel;
use app\models\PokazLimitsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * PokazLimitsController implements the CRUD actions for PokazLimits model.
 */
class PokazLimitsController extends Controller
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
     * Lists all PokazLimits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PokazLimitsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PokazLimits model.
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
     * Creates a new PokazLimits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PokazLimits();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreate1($pokaz_id)
    {
        $model = new PokazLimits();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'pokaz_id' => $pokaz_id,
        ]);
    }

    /**
     * Updates an existing PokazLimits model.
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
     * Deletes an existing PokazLimits model.
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
     * Finds the PokazLimits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PokazLimits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PokazLimits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetindikators($analiz_id,$sex,$birthdate,$myid)
    {
    	if(strlen($birthdate)>4){
    		$age = date('Y')-date('Y',strtotime($birthdate));	
    	}
        else{
        	$age = 1;
        }

        $result='';
        $models = SPokazatel::find()->where(['analiz_id'=>$analiz_id])->all();
        foreach ($models as $model) {
            $indikators = PokazLimits::find()->where(['pokaz_id'=>$model->id])->all();
            if(count($indikators)>1){
                $result.='<div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                              <div class="inner">';
                $result.="<p>".$model->title."</p>";
                
                foreach ($indikators as $indikator) {
                	$result.=PokazLimits::getUztextindikator($model->id,$indikator->indikator,$indikator->indikator_value,$sex,$birthdate,$age,$indikator->id,$myid);
                }
                $result.='</div>
                        </div>
                      </div>';
            }
        }
        // $result.='</div>';
        return $result;
    }
    
}

