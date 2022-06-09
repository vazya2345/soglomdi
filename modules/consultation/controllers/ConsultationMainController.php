<?php

namespace app\modules\consultation\controllers;

use Yii;
use app\modules\consultation\models\ConsultationMain;
use app\modules\consultation\models\ConsultationMainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\consultation\models\ConsultationDoriRecept;
use app\modules\consultation\models\ConsultationTashhisList;
use app\modules\consultation\models\ConsultationOperationList;
use app\modules\consultation\models\ConsultationAnnestezyList;

use app\modules\dori\models\DoriList;
use app\models\SAnaliz;
/**
 * ConsultationMainController implements the CRUD actions for ConsultationMain model.
 */
class ConsultationMainController extends Controller
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
     * Lists all ConsultationMain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsultationMainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConsultationMain model.
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
     * Creates a new ConsultationMain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConsultationMain();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ConsultationMain model.
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
     * Deletes an existing ConsultationMain model.
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
     * Finds the ConsultationMain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConsultationMain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConsultationMain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionConsultationsave($id)
    {



        // TASHHIS
        foreach (Yii::$app->request->post('consultation-tashhis') as $key => $value) {
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Ташхис';
            $model->value = ConsultationTashhisList::getName($key);
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-tashhis';
                var_dump($model->errors);die;
            }
        }
        if(Yii::$app->request->post('tashhis_custom')!=''){
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Ташхис';
            $model->value = Yii::$app->request->post('tashhis_custom');
            if($model->save()){
                unset($model);
            }
            else{
                echo 'tashhis_custom';
                var_dump($model->errors);die;
            }
        }


        //DORI RECEPT
        foreach (Yii::$app->request->post('ConsultationDoriRecept') as $key) {
            if($key['dori_title']!=''){
                $dmodel = new ConsultationDoriRecept();
                $dmodel->reg_id = $id;
                $dmodel->dori_title = DoriList::getName($key['dori_title']);
                $dmodel->dori_doza = $key['dori_doza'];
                $dmodel->dori_shakli = $key['dori_shakli'];
                $dmodel->dori_qabul = $key['dori_qabul'];
                $dmodel->dori_mahali = $key['dori_mahali'];
                $dmodel->dori_davomiyligi = $key['dori_davomiyligi'];
                $dmodel->dori_qayvaqtda = $key['dori_qayvaqtda'];
                $dmodel->create_date = date("Y-m-d H:i:s");
                $dmodel->create_userid = Yii::$app->user->id;
                if($dmodel->save()){
                    unset($dmodel);
                }
                else{
                    echo 'dori-recept';
                    var_dump($dmodel->errors);die;
                }
            }
            else{
                break;
            }
            
        }


        // ANALIZ
        foreach (Yii::$app->request->post('ConsultationAnalizs') as $key => $value) {
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Анализ';
            $model->value = SAnaliz::getName($value);
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-analiz';
                var_dump($model->errors);die;
            }   
        }
        if(Yii::$app->request->post('analiz_custom')!=''){
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Анализ';
            $model->value = Yii::$app->request->post('analiz_custom');
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-analiz_custom';
                var_dump($model->errors);die;
            }
        }

        // YOTOQ
        if(Yii::$app->request->post('cosultation-yotoq')!=''){
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Ётоқ';
            $model->value = Yii::$app->request->post('cosultation-yotoq');
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-yotoq';
                var_dump($model->errors);die;
            }
        }

        //OPERATSIYA
        foreach (Yii::$app->request->post('consultation-operations') as $key => $value) {
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Операция';
            $model->value = ConsultationOperationList::getName($key);
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-operations';
                var_dump($model->errors);die;
            }
        }
        if(Yii::$app->request->post('operatsiya_custom')!=''){
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Операция';
            $model->value = Yii::$app->request->post('operatsiya_custom');
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-operations-custom';
                var_dump($model->errors);die;
            }
        }


        //ANESTEZIYA
        foreach (Yii::$app->request->post('consultation-anestezy') as $key => $value) {
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Анестезия';
            $model->value = ConsultationAnnestezyList::getName($key);
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-anestezy';
                var_dump($model->errors);die;
            }
        }
        if(Yii::$app->request->post('anestezy_custom')!=''){
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Анестезия';
            $model->value = Yii::$app->request->post('anestezy_custom');
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-anestezy-custom';
                var_dump($model->errors);die;
            }
        }

        //OTHER INFO
        if(Yii::$app->request->post('custom-text-consultation')!=''){
            $model = new ConsultationMain();
            $model->reg_id = $id;
            $model->consultation_type = 'Бошқа изохлар';
            $model->value = Yii::$app->request->post('custom-text-consultation');
            if($model->save()){
                unset($model);
            }
            else{
                echo 'consultation-custom-text';
                var_dump($model->errors);die;
            }
        }
        

        return $this->redirect(['/registration/index']);
    }
}
