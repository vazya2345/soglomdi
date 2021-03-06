<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\FilialQoldiq;
use telegram\src\Api;
/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->getRole()!=1){
            return $this->redirect(['site/index']);
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['not in', 'role_id', [8]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexref()
    {
        if(Yii::$app->user->getRole()!=1){
            return $this->redirect(['site/index']);
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->andWhere(['role_id' => 8]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->getRole()!=1){
            return $this->redirect(['site/index']);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->getRole()!=1){
            return $this->redirect(['site/index']);
        }
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['Users']){
                $model->img = UploadedFile::getInstance($model, 'img');
                $url = 'uploads/' . time().'-'.$this->str2url($model->img->baseName) . '.' . $model->img->extension;
                if($model->img->baseName){
                    $model->img->saveAs($url);
                    $model->img = $url;
                }
                else{
                    $model->img = '';
                }                
            }
            else{
                echo "A";die;
            }

            if($model->save()){
                if($model->role_id==3){
                    $fq_model = new FilialQoldiq();
                    $fq_model->filial_id = $model->add1;
                    $fq_model->kassir_id = $model->id;
                    $fq_model->qoldiq = 0;
                    $fq_model->last_change_date = date("Y-m-d H:i:s");
                    if($fq_model->save()){
                        $a=1;
                    }
                    else{
                        var_dump($fq_model->errors);die;
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);    
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->getRole()!=1){
            return $this->redirect(['site/index']);
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatepas()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['updatepas', 'err' => 'success']);
        }

        return $this->render('updatepas', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function rus2translit($string) {
    $converter = array(
        '??' => 'a',   '??' => 'b',   '??' => 'v',
        '??' => 'g',   '??' => 'd',   '??' => 'e',
        '??' => 'e',   '??' => 'zh',  '??' => 'z',
        '??' => 'i',   '??' => 'y',   '??' => 'k',
        '??' => 'l',   '??' => 'm',   '??' => 'n',
        '??' => 'o',   '??' => 'p',   '??' => 'r',
        '??' => 's',   '??' => 't',   '??' => 'u',
        '??' => 'f',   '??' => 'h',   '??' => 'c',
        '??' => 'ch',  '??' => 'sh',  '??' => 'sch',
        '??' => 'y',  '??' => 'y',   '??' => 'y',
        '??' => 'e',   '??' => 'yu',  '??' => 'ya',
        
        '??' => 'A',   '??' => 'B',   '??' => 'V',
        '??' => 'G',   '??' => 'D',   '??' => 'E',
        '??' => 'E',   '??' => 'Zh',  '??' => 'Z',
        '??' => 'I',   '??' => 'Y',   '??' => 'K',
        '??' => 'L',   '??' => 'M',   '??' => 'N',
        '??' => 'O',   '??' => 'P',   '??' => 'R',
        '??' => 'S',   '??' => 'T',   '??' => 'U',
        '??' => 'F',   '??' => 'H',   '??' => 'C',
        '??' => 'Ch',  '??' => 'Sh',  '??' => 'Sch',
        '??' => 'y',  '??' => 'Y',   '??' => 'y',
        '??' => 'E',   '??' => 'Yu',  '??' => 'Ya',
    );
    return strtr($string, $converter);
    }


    public function str2url($str) {
        // ?????????????????? ?? ????????????????
        $str = $this->rus2translit($str);
        // ?? ???????????? ??????????????
        $str = strtolower($str);
        // ?????????????? ?????? ???????????????? ?????? ???? "-"
        $str = preg_replace('~[^-a-z0-9_.]+~u', '-', $str);
        // ?????????????? ?????????????????? ?? ???????????????? '-'
        $str = trim($str, "-");
        return $str;
    }

    public function actionTelegram()
    {
        // echo "A";die;
        $telegram = new Api('1733190802:AAFGkQYZzCDeq7pcO6UZakePsg5jueBdfvI'); //?????????????????????????? ??????????, ???????????????????? ?? BotFather
        $result = $telegram -> getWebhookUpdates(); //???????????????? ?? ???????????????????? $result ???????????? ???????????????????? ?? ?????????????????? ????????????????????????
        
        $text = $result["message"]["text"]; //?????????? ??????????????????
        $chat_id = $result["message"]["chat"]["id"]; //???????????????????? ?????????????????????????? ????????????????????????
        $name = $result["message"]["from"]["username"]; //???????????????? ????????????????????????
        $keyboard = [["?????????????????? ????????????"],["????????????????"],["??????????"]]; //????????????????????

        if($text){
             if ($text == "/start") {
                $reply = "?????????? ???????????????????? ?? ????????!";
                $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
            }elseif ($text == "/help") {
                $reply = "???????????????????? ?? ??????????????.";
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply ]);
            }elseif ($text == "????????????????") {
                $url = "https://68.media.tumblr.com/6d830b4f2c455f9cb6cd4ebe5011d2b8/tumblr_oj49kevkUz1v4bb1no1_500.jpg";
                $telegram->sendPhoto([ 'chat_id' => $chat_id, 'photo' => $url, 'caption' => "????????????????." ]);
            }elseif ($text == "??????????") {
                $url = "https://68.media.tumblr.com/bd08f2aa85a6eb8b7a9f4b07c0807d71/tumblr_ofrc94sG1e1sjmm5ao1_400.gif";
                $telegram->sendDocument([ 'chat_id' => $chat_id, 'document' => $url, 'caption' => "????????????????." ]);
            }elseif ($text == "?????????????????? ????????????") {
                $html=simplexml_load_file('http://netology.ru/blog/rss.xml');
                foreach ($html->channel->item as $item) {
             $reply .= "\xE2\x9E\xA1 ".$item->title." (<a href='".$item->link."'>????????????</a>)\n";
                }
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply ]);
            }else{
                $reply = "???? ?????????????? \"<b>".$text."</b>\" ???????????? ???? ??????????????.";
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply ]);
            }
        }else{
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "?????????????????? ?????????????????? ??????????????????." ]);
        }
    }

}
