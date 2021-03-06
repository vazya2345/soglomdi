<?php

namespace app\controllers;

use Yii;
use app\models\Rasxod;
use app\models\FilialQoldiq;
use app\models\Referals;
use app\models\RasxodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\OylikUderj;
use app\models\OylikPeriods;
use app\models\Users;
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
        if(Yii::$app->user->getRole()!=1&&Yii::$app->user->getRole()!=9){
            $dataProvider->query
            ->andWhere(['user_id'=>Yii::$app->user->id])
            ->orderBy(['id'=>SORT_DESC]);
        }
        else{
            $dataProvider->query
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

        $oylikuderj_model = new OylikUderj();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->create_date = date("Y-m-d H:i:s");
            if($model->save()){

                if($model->rasxod_type==5){
                    $oylikuderj_model->load(Yii::$app->request->post());
                    $oylikuderj_model->title = 3;
                    $oylikuderj_model->summa = $model->summa;
                    $oylikuderj_model->status = 1;
                    $oylikuderj_model->period = OylikPeriods::getActivePeriod();
                    $oylikuderj_model->create_date = date("Y-m-d H:i:s");
                    $oylikuderj_model->create_userid = Yii::$app->user->id;
                    $oylikuderj_model->rasxod_id = $model->id;
                    $oylikuderj_model->save(false);


                    $model->oylik_uderj_id = $oylikuderj_model->id;
                }
                
                $model->save(false);

                return $this->redirect(['view', 'id' => $model->id]);    
            }
            


            
        }

        return $this->render('create', [
            'model' => $model,
            'oylikuderj_model' => $oylikuderj_model,
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

        if ($model->load(Yii::$app->request->post())) {
            $model->filial_id = Users::getFilial($model->user_id);
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);    
            }
            
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

    public function actionQabul($id)
    {
        $model = $this->findModel($id);
        $fq_model = FilialQoldiq::find()->where(['kassir_id'=>$model->user_id,'qoldiq_type'=>$model->sum_type])->one();
        if($fq_model){
            if($fq_model->qoldiq>=$model->summa){
                if($model->status==1){
                    $fq_model->qoldiq -= $model->summa;
                    $model->status = 2;
                    $model->qabul_hodim_id = Yii::$app->user->id;
                    $model->mod_date = date("Y-m-d H:i:s");
                    if($fq_model->save()&&$model->save()){
                        if($model->rasxod_type==1){
                            $ref_phonenum = Referals::getPhonenumByRefnum($model->referal_id);
                            $ref_model = Referals::getByRefnum($model->referal_id);
                            if($ref_model){
                                if($ref_model->avans_sum<$model->summa){
                                    $fq_model->qoldiq += $ref_model->avans_sum;
                                    $ref_model->avans_sum = 0;

                                }
                                else{
                                    $ref_model->avans_sum = (int)$ref_model->avans_sum - (int)$model->summa;
                                    $fq_model->qoldiq += $model->summa;
                                    
                                }
                                $fq_model->save(false);
                                $ref_model->save(false);
                                // var_dump($ref_model);die;
                            }
                            // var_dump($ref_phonenum);die;



                            return $this->redirect(['registration/refsendsmsact', 'ref_phonenum'=>$ref_phonenum, 'ref_sum'=>$model->summa]);
                        }
                        elseif($model->rasxod_type==5){
                            $oylikuderj_model = OylikUderj::findOne($model->oylik_uderj_id);
                            $oylikuderj_model->status = 2;
                            $oylikuderj_model->save(false);
                            return $this->redirect(['index']); 

                        }
                        else{
                            return $this->redirect(['index']);    
                        }
                        
                    }
                    else{
                        var_dump($fq_model->errors);
                        var_dump($model->errors);
                    }  
                }
                else{
                    return $this->redirect(['index']);
                }
                
                // $fq_model->last_change_date = date("Y-m-d H:i:s");
                
                

                
                  
            }
            else{
                echo "?????????????? ???????????? ???????????? ???????????? ????????.";die;
            }
        }
        else{
            echo "?????????? ??????????????????.";die;
        }
        

            
    }


    public function actionRad($id)
    {
        $model = $this->findModel($id);
        
        $model->status = 3;
        $model->qabul_hodim_id = Yii::$app->user->id;
        $model->mod_date = date("Y-m-d H:i:s");

        $uderj_model = OylikUderj::findOne($model->oylik_uderj_id);
        if($uderj_model){
            $uderj_model->status = 3;
            $uderj_model->save(false);
        }

        if($model->save()){
            return $this->redirect(['index']);
        }
        else{
            var_dump($model->errors);
        }        
    }



}
