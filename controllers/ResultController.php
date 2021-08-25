<?php

namespace app\controllers;

use Yii;
use app\models\Result;
use app\models\ResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Registration;
use app\models\RegAnalizs;
use app\models\SPokazatel;
use app\models\SAnaliz;
/**
 * ResultController implements the CRUD actions for Result model.
 */
class ResultController extends Controller
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
     * Lists all Result models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Result model.
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
     * Creates a new Result model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Result();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Result model.
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
     * Deletes an existing Result model.
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
     * Finds the Result model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Result the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Result::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTest($key)
    {
        // die;
        $analizs = SAnaliz::find()->where(['group_id'=>21])->andWhere(['not in', 'id', [158,161,165]])->all();
        
        $pokazs = SPokazatel::find()->where(['analiz_id'=>158])->all();
        // var_dump($pokazs);


        foreach ($analizs as $analiz) {
            foreach($pokazs as $pokaz){
                $new_pokaz = new SPokazatel();
                $new_pokaz->title = $pokaz->title;
                $new_pokaz->analiz_id = $analiz->id;
                $new_pokaz->inptype_id = $pokaz->inptype_id;
                if(!$new_pokaz->save()){
                    var_dump($new_pokaz->errors);die;
                }
            }
        }
        echo "OK";
        die;die;
        // $regs = RegAnalizs::find()->where(['in','analiz_id',[134,249]])->andWhere(['<','reg_id',21108])->andWhere(['>','reg_id',21095])->asArray()->orderBy(['id' => SORT_ASC])->all();
        // // var_dump($regs);die;
        // foreach ($regs as $reg) {

        //     $result_model = Result::find()->where(['main_id'=>$reg['reg_id']])->all();
        //     if($result_model){
        //         continue;
        //     }
        //     else{
        //         $result_model = new Result();
        //         $result_model->main_id = $reg['reg_id'];
        //         $result_model->analiz_id = $reg['analiz_id'];
        //         if($reg['analiz_id']==134){
        //             $result_model->pokaz_id = 253;
        //         }
        //         else{
        //             $result_model->pokaz_id = 318;
        //         }
        //         $result_model->reslut_value = 'Отрицательный';
        //         $result_model->create_date = '2021-07-28 23:11:11';
        //         $result_model->user_id = 77; 
        //         if($result_model->save()){
        //             $registr_model = Registration::findOne($result_model->main_id);
        //             if($registr_model){
        //                 $registr_model->status = 4;
        //                 if(strlen($registr_model->ref_code) == 0){
        //                     $registr_model->ref_code = '911';
        //                 }
        //                 $registr_model->lab_vaqt = '2021-07-28 23:11:11';
        //                 if($registr_model->save()){
        //                     $a = 1;
        //                 }
        //                 else{
        //                     echo "Registr";
        //                     var_dump($registr_model->errors);die;
        //                 }
        //             }
                    
        //         }
        //         else{
        //             echo "Result";
        //             var_dump($result_model->errors);die;
        //         }
        //         echo $result_model->main_id."<br>";
        //     }             
        // }

        // echo "ok";die;
    }
}


//select id, status from registration where id in (SELECT reg_id FROM `reg_analizs` WHERE `analiz_id` IN (134,249)) and id<21108