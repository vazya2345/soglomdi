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
use app\models\OylikUderjTypes;
use app\models\Filials;
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
        $searchModel = new OylikShaklSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['period' => SORT_DESC, 'shakl_id'=>SORT_ASC],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
        \Yii::$app
        ->db
        ->createCommand()
        ->delete('oylik_shakl', ['period' => OylikPeriods::getActivePeriod()])
        ->execute();

        $hodimlar = OylikHodimlar::find()->all();
        foreach ($hodimlar as $hodim) {
            /// OKLAD
            $shmodel1 = new OylikShakl();
            $shmodel1->period = OylikPeriods::getActivePeriod();
            $shmodel1->oylik_hodimlar_id = $hodim->id;
            $shmodel1->fio = $hodim->fio;
            $shmodel1->fil_name = Filials::getName($hodim->filial_id);
            $shmodel1->lavozim = $hodim->lavozim;
            $shmodel1->title = 'Оклад';
            $shmodel1->summa = $hodim->summa;
            $shmodel1->shakl_id = 1;

            if($shmodel1->save()){
                $uderjsum = 0;
                $uderjs = OylikUderj::find()->where(['oylik_hodimlar_id'=>$hodim->id, 'period'=>$shmodel1->period])->all();
                foreach ($uderjs as $uderj) {
                    $shmodel2 = new OylikShakl();
                    $shmodel2->period = $shmodel1->period;
                    $shmodel2->oylik_hodimlar_id = $uderj->oylik_hodimlar_id;
                    $shmodel2->fio = $hodim->fio;
                    $shmodel2->fil_name = $shmodel1->fil_name;
                    $shmodel2->lavozim = $hodim->lavozim;
                    $shmodel2->title = OylikUderjTypes::getName($uderj->title);
                    $shmodel2->summa = $uderj->summa;
                    $uderjsum += $uderj->summa;
                    $shmodel2->shakl_id = 2;
                    $shmodel2->save(false);
                }

                /// QOLDIQ
                $shmodel3 = new OylikShakl();
                $shmodel3->period = $shmodel1->period;
                $shmodel3->oylik_hodimlar_id = $hodim->id;
                $shmodel3->fio = $hodim->fio;
                $shmodel3->fil_name = $shmodel1->fil_name;
                $shmodel3->lavozim = $hodim->lavozim;
                $shmodel3->title = 'Қолдиқ';
                $shmodel3->summa = $hodim->summa-$uderjsum;
                $shmodel3->shakl_id = 3;

                if($shmodel3->save()){
                    $a = 1;
                }
                else{
                    var_dump($shmodel3->shakl_id."da xato!");die;
                }

            }
            else{
                var_dump($shmodel1->errors);die;
            }


        }



        return $this->redirect(['index']);
    }


    public function actionAvans()
    {
        \Yii::$app
        ->db
        ->createCommand()
        ->delete('oylik_shakl', ['period' => OylikPeriods::getActivePeriod(), 'title'=>'Аванс'])
        ->execute();

        \Yii::$app
        ->db
        ->createCommand()
        ->delete('oylik_uderj', ['period' => OylikPeriods::getActivePeriod(), 'title'=>1])
        ->execute();

        $hodimlar = OylikHodimlar::find()->all();
        foreach ($hodimlar as $hodim) {
            /// OKLAD
            $shmodel1 = new OylikShakl();
            $shmodel1->period = OylikPeriods::getActivePeriod();
            $shmodel1->oylik_hodimlar_id = $hodim->id;
            $shmodel1->fio = $hodim->fio;
            $shmodel1->fil_name = Filials::getName($hodim->filial_id);
            $shmodel1->lavozim = $hodim->lavozim;
            $shmodel1->title = 'Аванс';
            $shmodel1->summa = round($hodim->summa*0.4);
            $shmodel1->shakl_id = 2;




            $umodel = new OylikUderj();
            $umodel->oylik_hodimlar_id = $hodim->id;
            $umodel->title = '1';
            $umodel->summa = $shmodel1->summa;
            $umodel->period = $shmodel1->period;
            $umodel->create_date = date("Y-m-d H:i:s");
            $umodel->create_userid = Yii::$app->user->id;




            if($shmodel1->save()&&$umodel->save()){
                $a=1;
            }
            else{
                var_dump($umodel->errors);
                var_dump($shmodel1->errors);die;
            }


        }
        return $this->redirect(['index']);
    }
}
