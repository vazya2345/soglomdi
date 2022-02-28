<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\ReagentNotifications;
use app\models\ReagentRel;
use app\models\ReagentFilial;
use app\models\Users;
use app\models\SAnaliz;

use app\models\RegReagents;
use app\models\RegAnalizs;
use app\models\Result;

/**
 * This is the model class for table "reagent".
 *
 * @property int $id
 * @property string $title
 * @property int $qoldiq
 * @property int $martalik
 * @property string $add1
 * @property int $check
 */
class Reagent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reagent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'qoldiq', 'martalik', 'check'], 'required'],
            [['qoldiq', 'martalik', 'check', 'price', 'notific_count', 'notific_filial'], 'integer'],
            [['title', 'add1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Номи',
            'qoldiq' => 'Қолдиқ',
            'martalik' => 'Кўп марталиги',
            'add1' => 'Қўшимча',
            'check' => 'Тури',
            'price' => 'Нархи',
            'notific_count' => 'Огохлантириш чегараси',
            'notific_filial' => 'Филиал огохлантириш чегараси',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->orderBy(['title'=>SORT_ASC])->all();
        $result = ArrayHelper::map($array, 'id', 'title');
        return $result;
    }

    public static function getBirMartaArray()
    {
        $array = self::find()->where(['check'=>7])->all();
        $res = [];
        $i=0;
        foreach($array as $key){
            $res[$i]=$key->id;
            $i++;
        }
        return $res;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->title;
        else
            return 'Топилмади';
    }

    public static function getPrice($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->price;
        else
            return 0;
    }

    public static function isBirMarta($id)
    {
        $model = self::findOne($id);
        if($model&&$model->check==1)
            return true;
        else
            return false;
    }

    public static function checkReagents($analiz_id)
    {
        $reagents = ReagentRel::checkReagentsByAnalizId($analiz_id);
        $arr = Reagent::getBirMartaArray();
        $myfil = Users::getMyFil();
        $res = [];
        $i=0;
        $status = 1;
        if($reagents){
            foreach($reagents as $key){
                if(in_array($key->reagent_id, $arr)){
                    $rf = ReagentFilial::findByFilAndReagent($myfil,$key->reagent_id);
                    if($rf){
                        $res[$i]['reagent_id'] = $key->reagent_id;
                        $res[$i]['reagent_name'] = self::getName($key->reagent_id);
                        $res[$i]['reagent_soni'] = $rf->qoldiq;
                        if($rf->qoldiq>0){
                            $res[$i]['reagent_status'] = 1;
                        }
                        else{
                            $res[$i]['reagent_status'] = 0;
                            $status=0;
                        }
                        
                    }else{
                        $res[$i]['reagent_id'] = $key->reagent_id;
                        $res[$i]['reagent_name'] = self::getName($key->reagent_id);
                        $res[$i]['reagent_soni'] = 'Мавжуд эмас';
                        $res[$i]['reagent_status'] = 0;
                        $status=0;
                    }
                }
                else{
                    if(SAnaliz::isFil($analiz_id)){
                        $rf = ReagentFilial::findByFilAndReagent($myfil,$key->reagent_id);
                        if($rf){
                            $res[$i]['reagent_id'] = $key->reagent_id;
                            $res[$i]['reagent_name'] = self::getName($key->reagent_id);
                            $res[$i]['reagent_soni'] = $rf->qoldiq;
                            if($rf->qoldiq>0){
                                $res[$i]['reagent_status'] = 1;
                            }
                            else{
                                $res[$i]['reagent_status'] = 0;
                                $status=0;
                            }
                            
                        }else{
                            $res[$i]['reagent_id'] = $key->reagent_id;
                            $res[$i]['reagent_name'] = self::getName($key->reagent_id);
                            $res[$i]['reagent_soni'] = 'Мавжуд эмас';
                            $res[$i]['reagent_status'] = 0;
                            $status=0;
                        }
                    }
                    else{
                        $rmodel = self::findOne($key->reagent_id);
                        if($rmodel){
                            $res[$i]['reagent_id'] = $key->reagent_id;
                            $res[$i]['reagent_name'] = self::getName($key->reagent_id);
                            $res[$i]['reagent_soni'] = $rmodel->qoldiq;
                            if($rmodel->qoldiq>0){
                                $res[$i]['reagent_status'] = 1;
                            }
                            else{
                                $res[$i]['reagent_status'] = 0;
                                $status=0;
                            }
                        }
                        else{
                            $res[$i]['reagent_id'] = $key->reagent_id;
                            $res[$i]['reagent_name'] = self::getName($key->reagent_id);
                            $res[$i]['reagent_soni'] = 'Мавжуд эмас';
                            $res[$i]['reagent_status'] = 0;
                            $status=0;
                        }

                    }
                }
                $i++;
            }
        }
        $result = [];
        $result['status'] = $status;
        $result['info'] = $res;
        return $result;
    }

    public static function minusCount($id,$count,$analiz_id,$reg_id)
    {
        $myfil = Users::getMyFil();
        $reagent = self::findOne($id);
        if($reagent){
            if($reagent->check==1&&!SAnaliz::isFil($analiz_id)){// agar analiz filialda tekshirilmasa
                

                if($reagent->qoldiq>=$count){
                    $reagent->qoldiq-=$count;
                }
                else{
                    echo "Складда ушбу реагентлар миқдори кўрсатилгандан кам қолган. Бош офисга боғланинг. reagent_id(".self::getName($id).") error(r1)";die;
                }
                if($reagent->save()){
                    $regreagent_model = new RegReagents();
                    $regreagent_model->reg_id = $reg_id;
                    $regreagent_model->reagent_id = $id;
                    $regreagent_model->soni = $count;
                    $regreagent_model->filial_id = $myfil;
                    if($regreagent_model->save()){
                        $a=1;
                    }
                    else{
                        var_dump($regreagent_model->errors);
                        echo "REGREAGENTERROR!!!";die;
                    }


                    if($reagent->qoldiq<=$reagent->notific_count&&!ReagentNotifications::isReagent($id, 777)){
                        $notif_model = new ReagentNotifications();
                        $notif_model->reagent_id = $id;
                        $notif_model->create_date = date("Y-m-d H:i:s");
                        $notif_model->filial_id = 777; //// SKLAD
                        if($notif_model->save()){
                            return true;
                        }
                        else{
                            var_dump($notif_model);die;
                        }
                    }
                    else{
                        return true;
                    }    
                }
                else{
                    var_dump($reagent->errors);die;
                }
            }
            else{
                $model = ReagentFilial::findByFilAndReagent($myfil,$id);
                if($model){
                    if($model->qoldiq>=$count){
                        $model->qoldiq-=$count;
                    }
                    else{
                        echo "Реагентлар миқдори кўрсатилгандан кам қолган. Бош офисга боғланинг. reagent_id(".self::getName($id).' - '.$id.") error(r1)";die;
                    }
                    if($model->save()){
                        $regreagent_model = new RegReagents();
                        $regreagent_model->reg_id = $reg_id;
                        $regreagent_model->reagent_id = $id;
                        $regreagent_model->soni = $count;
                        $regreagent_model->filial_id = $myfil;
                        if($regreagent_model->save()){
                            if($model->qoldiq<=$reagent->notific_filial&&!ReagentNotifications::isReagent($id, $myfil)){
                                $notif_model = new ReagentNotifications();
                                $notif_model->reagent_id = $id;
                                $notif_model->create_date = date("Y-m-d H:i:s");
                                $notif_model->filial_id = $myfil; //// FILIAL
                                if($notif_model->save()){
                                    return true;
                                }
                                else{
                                    var_dump($notif_model);die;
                                }
                            }
                            else{
                                return true;
                            }
                        }
                        else{
                            var_dump($regreagent_model->errors);
                            echo "REGREAGENTERROR!!!";die;
                        }
                    }
                    else{
                        var_dump($model);die;
                    }
                }
                else{
                    echo "Ушбу реагент филиалда кўрсатилмаган. Бош офисга боғланинг. reagent_id(".self::getName($id).' - '.$id.") error(r2)";die;
                }

            }
        }
        else{
            echo "Бундай реагент топилмади. Бош офисга боғланинг. reagent_id(".self::getName($id).' - '.$id.") error(r3)";die;
        }
    }

    public static function minusCountForAnaliz($id,$reg_id)
    {

        $models = ReagentRel::getReagentsForAnaliz($id);

        if($models){

            foreach ($models as $key) {
                self::minusCount($key->reagent_id,1,$id,$reg_id);
            }
        }
        else{
            return false;
        }
    }


    public static function getForRegText()
    {
        $res = '
                            <div class="card card-success">
                              <div class="card-header border-0">
                                <div>
                                  <h3 class="card-title">Бир марталик воситалар</h3>
                                </div>
                              </div>
                              <div class="card-body">
                                <div>';
                                    $reagents = Reagent::find()->where(['check'=>7])->all();
                                    $res.="<table class='reagent_birmarta'>";
                                    foreach ($reagents as $reagent) {
                                        // if($reagent->martalik>1){
                                            $res.=" <tr>
                                                        <td class='reagent_title'>".$reagent->title."</td>
                                                        <td>
                                                            <div class='input-group mb-3'>
                                                              <div class='input-group-prepend' id='myreagminus".$reagent->id."' onclick='myfuncminus(".$reagent->id.")'>
                                                                <span class='input-group-text'>
                                                                 <i class='fas fa-minus'></i>
                                                                </span>
                                                              </div>
                                                              <input id='myreaginp".$reagent->id."' type='number' class='form-control' name='reagent[".$reagent->id."]' value='0' max='10' min='0'>
                                                              <div class='input-group-append'  id='myreagplus".$reagent->id."'  onclick='myfuncplus(".$reagent->id.")'>
                                                                <span class='input-group-text'><i class='fas fa-plus'></i></span>
                                                              </div>
                                                            </div>
                                                        </td>
                                                    </tr>";
                                    }
                                    $res.="</table>";
        $res.= '                  </div>
                              </div>
                            </div>
                    
                ';
        return $res;
    }

    public static function getForRegText1()
    {
        $res = '
                            <div class="card card-success" id="accordionreagent">
                              <div class="card-header border-0">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapsereagent" aria-expanded="true">
                                          Бир марталик воситалар
                                        </a>
                                    </h4>
                              </div>
                              <div id="collapsereagent" class="collapse show" data-parent="#accordionreagent">
                                  <div class="card-body">
                                    <div>';
                                        $reagents = Reagent::find()->where(['check'=>7])->orderBy(['add1'=>SORT_ASC])->all();
                                        $res.="<table class='reagent_birmarta'>";
                                        foreach ($reagents as $reagent) {
                                            if(in_array($reagent->id, [205,206,216,208,209,215])){
                                                $res.=" <tr>
                                                            <td class='reagent_title'>".$reagent->title."</td>
                                                            <td>
                                                                <div class='input-group mb-3'>
                                                                  <div class='input-group-prepend' id='myreagminus".$reagent->id."' onclick='myfuncminus(".$reagent->id.")'>
                                                                    <span class='input-group-text'>
                                                                     <i class='fas fa-minus'></i>
                                                                    </span>
                                                                  </div>
                                                                  <input id='myreaginp".$reagent->id."' type='number' class='form-control' name='reagent[".$reagent->id."]' value='0' max='10' min='0'>
                                                                  <div class='input-group-append'  id='myreagplus".$reagent->id."'  onclick='myfuncplus(".$reagent->id.")'>
                                                                    <span class='input-group-text'><i class='fas fa-plus'></i></span>
                                                                  </div>
                                                                </div>
                                                            </td>
                                                        </tr>";
                                            }
                                            else{
                                                $res.="<input id='myreaginp".$reagent->id."' type='hidden' name='reagent[".$reagent->id."]' value='0'>";
                                            }
                                        }
                                        $res.="</table>";
            $res.= '                  </div>
                                  </div>
                              </div>
                            </div>
                    
                ';
        return $res;
    }
    public static function regOtmen($reg_id){
        $myfil = Users::getMyFil();
        $reganalizs = RegAnalizs::find()->where(['reg_id'=>$reg_id])->all();
        foreach ($reganalizs as $key) {
            $key->delete();
        }
        $res = Result::find()->where(['main_id'=>$reg_id])->all();
        foreach ($res as $key) {
            $key->delete();
        }
        $regreagents = RegReagents::find()->where(['reg_id'=>$reg_id])->all();
        foreach ($regreagents as $key) {
            $rm=false;
            $fq=false;
            $fq = ReagentFilial::find()->where(['reagent_id'=>$key->reagent_id,'filial_id'=>$myfil])->one();
            if($fq){
                $fq->qoldiq+=$key->soni;
                $fq->save(false);
            }
            else{
                $rm = self::findOne($key->reagent_id);
                $rm->qoldiq+=$key->soni;
                $rm->save(false);
            }
            $key->delete();
            unset($fq);
            unset($rm);
        }
        return true;
    }



    public static function getForUpdateText($reg_id)
    {
        $res = '
                            <div class="card card-success" id="accordionreagent">
                              <div class="card-header border-0">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapsereagent" aria-expanded="true">
                                          Бир марталик воситалар
                                        </a>
                                    </h4>
                              </div>
                              <div id="collapsereagent" class="collapse show" data-parent="#accordionreagent">
                                  <div class="card-body">
                                    <div>';
                                        $reagents = Reagent::find()->where(['check'=>7])->orderBy(['add1'=>SORT_ASC])->all();
                                        $res.="<table class='reagent_birmarta'>";
                                        foreach ($reagents as $reagent) {
                                            $val = RegReagents::getReagentCount($reagent->id,$reg_id);
                                            if(in_array($reagent->id, [205,206,216,208,209,215])){
                                                $res.=" <tr>
                                                            <td class='reagent_title'>".$reagent->title."</td>
                                                            <td>
                                                                <div class='input-group mb-3'>
                                                                  <div class='input-group-prepend' id='myreagminus".$reagent->id."' onclick='myfuncminus(".$reagent->id.")'>
                                                                    <span class='input-group-text'>
                                                                     <i class='fas fa-minus'></i>
                                                                    </span>
                                                                  </div>
                                                                  <input id='myreaginp".$reagent->id."' type='number' class='form-control' name='reagent[".$reagent->id."]' value='".$val."' max='10' min='0'>
                                                                  <div class='input-group-append'  id='myreagplus".$reagent->id."'  onclick='myfuncplus(".$reagent->id.")'>
                                                                    <span class='input-group-text'><i class='fas fa-plus'></i></span>
                                                                  </div>
                                                                </div>
                                                            </td>
                                                        </tr>";
                                            }
                                            else{
                                                $res.="<input id='myreaginp".$reagent->id."' type='hidden' name='reagent[".$reagent->id."]' value='0'>";
                                            }
                                        }
                                        $res.="</table>";
            $res.= '                  </div>
                                  </div>
                              </div>
                            </div>
                    
                ';
        return $res;
    }

    public static function getUmumSumQoldiq(){
        $command = Yii::$app->db->createCommand("SELECT sum(qoldiq*price) FROM reagent");
        $sum = $command->queryScalar();
        return $sum;
    }

    
}

?>
