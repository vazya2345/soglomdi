<?php

namespace app\controllers;

use Yii;
use app\models\Client;
use app\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
     * Lists all Client models.
     // Avaz
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
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
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->change_date = date("Y-m-d H:i:s");
            if($model->save()){
                // var_dump(Yii::$app->request->post('return_url'));die;
                return $this->redirect(Yii::$app->request->post('return_url'));
            }
            else{
                var_dump($model->errors);die;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
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
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCheckdoc($seria,$number)
    {
        header('Content-Type: application/json');
        $result = [];
        $model = Client::find()->where(['doc_seria'=>$seria])->andWhere(['doc_number'=>$number])->one();
        if($model){
            $result['fname'] = $model->fname;
            $result['lname'] = $model->lname;
            $result['mname'] = $model->mname;

            $result['birthdate'] = $model->birthdate;
            $result['sex'] = $model->sex;
        }
        return json_encode($result);
    }

    public function actionGetclientbyid($id)
    {
        header('Content-Type: application/json');
        $result = [];
        $model = Client::findOne($id);
        if($model){
            $result['fname'] = $model->fname;
            $result['lname'] = $model->lname;
            $result['mname'] = $model->mname;

            $result['doc_seria'] = $model->doc_seria;
            $result['doc_number'] = $model->doc_number;

            $result['address_tuman'] = $model->address_tuman;
            $result['address_text'] = $model->address_text;

            $result['birthdate'] = $model->birthdate;
            $result['sex'] = $model->sex;

            $result['add1'] = $model->add1;
        }
        return json_encode($result);
    }
}
