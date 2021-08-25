<?php

namespace app\controllers;

use Yii;
use app\models\Reagent;
use app\models\ReagentRel;
use app\models\Users;
use app\models\SAnaliz;
use app\models\ReagentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReagentController implements the CRUD actions for Reagent model.
 */
class ReagentController extends Controller
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
     * Lists all Reagent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReagentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reagent model.
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
     * Creates a new Reagent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Reagent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reagent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // var_dump(Yii::$app->request->post());die;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reagent model.
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
     * Finds the Reagent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reagent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reagent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGenerate()
    {
        // $models = SAnaliz::find()->all();
        // foreach ($models as $key) {
        //     $new = new ReagentRel();
        //     $new->analiz_id = $key->id;
        //     $new->reagent_id = 205;
        //     $new->soni = 1;
        //     $new->save(false);
        //     $new2 = new ReagentRel();
        //     $new2->analiz_id = $key->id;
        //     $new2->reagent_id = 207;
        //     $new2->soni = 1;
        //     $new2->save(false);
        //     $new3 = new ReagentRel();
        //     $new3->analiz_id = $key->id;
        //     $new3->reagent_id = 209;
        //     $new3->soni = 1;
        //     $new3->save(false);
        //     $new4 = new ReagentRel();
        //     $new4->analiz_id = $key->id;
        //     $new4->reagent_id = 210;
        //     $new4->soni = 1;
        //     $new4->save(false);
        // }


        var_dump(Users::getFilPhoneNum(12));die;


        echo "OK";die;
    }

    public function actionCheckreagents($analiz_id)
    {
        header('Content-Type: application/json');

        $res = Reagent::checkReagents($analiz_id);
        foreach ($res['info'] as $key) {
            if($key['reagent_soni']<1){
                $content .= '
                <div class="col-lg-3" id="reag_alert'.$key['reagent_id'].'">
                    <div class="alert alert-warning alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <i class="icon fas fa-exclamation-triangle"></i> '.$key['reagent_name'].' қолмаган.
                    </div>
                </div>
                ';
            }
        }
        
        
        $res['info'] = $content;
        return json_encode($res);
    }

    // public function actionCheckreagentsMinus($analiz_id)
    // {
    //     header('Content-Type: application/json');

    //     $res = Reagent::checkReagents($analiz_id);
    //     foreach ($res['info'] as $key) {
    //         if($key['reagent_soni']<1){
    //             $content .= '
    //             <div class="col-lg-3" id="reag_alert'.$key['reagent_id'].'">
    //                 <div class="alert alert-warning alert-dismissible">
    //                   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //                   <i class="icon fas fa-exclamation-triangle"></i> '.$key['reagent_name'].' қолмаган.
    //                 </div>
    //             </div>
    //             ';
    //         }
    //     }
        
        
    //     $res['info'] = $content;
    //     return json_encode($res);
    // }
}
