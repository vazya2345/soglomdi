<?php

namespace app\models;

use Yii;
use app\models\Registration;
use app\models\RegDopinfo;
use app\models\SPokazatel;

/**
 * This is the model class for table "pokaz_limits".
 *
 * @property int $id
 * @property int|null $pokaz_id
 * @property string|null $indikator
 * @property string|null $indikator_value
 * @property string|null $norma
 * @property string|null $down_limit
 * @property string|null $up_limit
 * @property string|null $add1
 */
class PokazLimits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pokaz_limits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pokaz_id'], 'integer'],
            [['indikator', 'down_limit', 'up_limit'], 'string', 'max' => 30],
            [['indikator_value'], 'string', 'max' => 50],
            [['norma', 'add1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pokaz_id' => 'Показатель',
            'indikator' => 'Индикатор',
            'indikator_value' => 'Индикатор киймати',
            'norma' => 'Норма',
            'down_limit' => 'Пастги чегара',
            'up_limit' => 'Юкори чегара',
            'add1' => 'Батафсил',
        ];
    }

    public static function getUztextindikator($pokaz_id,$indikator,$indikator_value,$sex,$birthdate,$age,$indikator_id,$myid,$checked='') 
    {

        $result = '';
        $res = '';
        if($indikator=='Жинси'){
            if($sex=='M'&&$indikator_value=='Эркак'){
                $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$indikator_value."</label><br>";
            }
            elseif($sex=='F'&&$indikator_value=='Аёл'){
                $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$indikator_value."</label><br>";
            }
            else{
                if($indikator_id==$checked){
                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$indikator_value."</label><br>";
                }
                else{
                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' /> ".$indikator.' - '.$indikator_value."</label><br>";    
                }
                
            }
        }
        elseif(substr($indikator_value, 0, 1)=='f'||substr($indikator_value, 0, 1)=='t'){
            if(substr($indikator_value, 0, 1)=='t'){
                switch ($indikator_value) {
                    case 't9h-12h:mejdu':
                        $res = 'Соат 9дан 12гача';
                        break;
                    case 't12h:after':
                        $res = 'Соат 12дан кейин';
                        break;
                    
                    default:
                        $res = 'Топилмади';
                        break;
                }
                if($indikator_id==$checked){
                    return $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$res."</label><br>";
                }
                else{
                    return $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' /> ".$indikator.' - '.$res."</label><br>";    
                }
                
            }
            else{
                $arr = explode("~", $indikator_value);
                $res = '';
                foreach ($arr as $key => $value) {
                    $arr1 = explode(':', $value);
                    if($arr1[0]=='sex'){
                        if($arr1[1]=='m'){
                            $jinsi=' эркак';
                        }
                        elseif($arr1[1]=='f'){
                            $jinsi=' аёл';
                        }
                        else{
                            $jinsi='';
                        }
                    }
                    elseif(in_array($arr1[1], ['after','do','mejdu'])){
                        if(in_array($arr1[1], ['mejdu'])){
                            $arr2_str = substr($arr1[0], 1, strlen($arr1[0])-2);
                            if(strpos($arr2_str, 'y-') !== false){
                                $arr2 = explode('y-', $arr2_str);
                                $norm_age1 = $arr2[0];
                                $norm_age2 = $arr2[1];
                                if($age>=$norm_age1&&$age<=$norm_age2){
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$norm_age1." ва ".$norm_age2." ёш орасида {jinsi}</label><br>";
                                }
                                else{
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' /> ".$indikator.' - '.$norm_age1." ва ".$norm_age2." ёш орасида {jinsi}</label><br>";
                                }
                            }
                            elseif(strpos($arr2_str, 'm-') !== false){
                                $arr2 = explode('y-', $arr2_str);
                                $norm_age1 = $arr2[0];
                                $norm_age2 = $arr2[1];
                                if($age>=$norm_age1&&$age<=$norm_age2){
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$norma_age." ёшдан кичик {jinsi}</label><br>";
                                }
                                else{
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' /> ".$indikator.' - '.$norma_age." ёшдан кичик {jinsi}</label><br>";
                                }
                            }
                        }
                        else{
                            if($arr1[1]=='do'){
                                $norma_age = substr($arr1[0], 1, strlen($arr1[0])-2);
                                if($age<=$norma_age){
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$norma_age." ёшдан кичик {jinsi}</label><br>";
                                }
                                else{
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' /> ".$indikator.' - '.$norma_age." ёшдан кичик {jinsi}</label><br>";
                                }
                            }
                            else{
                                $norma_age = substr($arr1[0], 1, strlen($arr1[0])-2);
                                if($age>$norma_age){
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.$norma_age." ёшдан катта {jinsi}</label><br>";
                                }
                                else{
                                    $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' /> ".$indikator.' - '.$norma_age." ёшдан катта {jinsi}</label><br>";
                                }
                            }
                        }
                    }
                    else{
                        return $value;
                    }
                }
                $result = str_replace('{jinsi}', $jinsi, $result);
            }
        }
        else{
            if($indikator_id==$checked){
                $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked  /> ".$indikator.' - '.PokazLimits::getUztextindikatorvalue($indikator_value)."</label><br>";
            }
            else{
                $result.="<label><input type='radio' name=pokaz[".$myid."][".$pokaz_id."] value='".$indikator_id."' checked /> ".$indikator.' - '.PokazLimits::getUztextindikatorvalue($indikator_value)."</label><br>";
            }
        }
        // $result = str_replace('{jinsi}', $jinsi, $result);
        return $result;
    }

    public static function getUztextindikatorvalue($text)
    {
        if(substr($text, 0, 1)=='f'||substr($text, 0, 1)=='t'){
            if(substr($text, 0, 1)=='t'){
                switch ($text) {
                    case 't9h-12h:mejdu':
                        $res = 'Соат 9дан 12гача';
                        break;
                    case 't12h:after':
                        $res = 'Соат 12дан кейин';
                        break;
                    
                    default:
                        $res = 'Топилмади';
                        break;
                }
            }
            else{
                $arr = explode("~", $text);
                $res = '';
                foreach ($arr as $key => $value) {
                    $arr1 = explode(':', $value);
                    if($arr1[0]=='sex'){
                        if($arr1[1]=='m'){
                            $res.=' эркак';
                        }
                        elseif($arr1[1]=='f'){
                            $res.=' аёл';
                        }
                        else{
                            return 'Топилмади';
                        }
                    }
                    elseif(in_array($arr1[1], ['after','do','mejdu'])){
                        if(in_array($arr1[1], ['mejdu'])){

                        }
                        else{
                            if($arr1[1]=='do'){
                                $norma_age = substr($arr1[0], 1, strlen($arr1[0])-1);
                                if($age<=$norma_age){

                                }
                            }
                            else{
                                $norma_age = substr($arr1[0], 1, strlen($arr1[0])-1);

                            }
                        }
                    }
                    else{
                        return $value;
                    }
                }

            }
            return $res;
        }
        else{
            return $text;
        }
        die;
        switch ($text) {
            case 'm':
                $res = 'Эркак';
                break;
            case 'f':
                $res = 'Аёл';
                break;
            default:
                $res = 'Дефолт';
                break;
        }
        return $res;
    }

    public static function getClassByValue($main_id,$pokaz_id,$result)
    {
        
        $limits = self::find()->where(['pokaz_id'=>$pokaz_id])->all();

        if(count($limits)>1){
            $dop = RegDopinfo::find()->where(['reg_id'=>$main_id,'indikator_id'=>$pokaz_id])->one();
            if($dop){
                $limit = self::findOne($dop->value);
                if($limit){
                    if(($result>=$limit->down_limit&&$result<=$limit->up_limit)||($result==$limit->norma)){
                        $class = 'success';
                    }
                    else{
                        $class = 'danger';
                    }
                }
                else{
                    $class = 'warning';    
                }
            }
            else{
                $class = 'warning';
            }
        }
        else{
            if(isset($limits[0])){
                $limit = $limits[0];
                if(($result>=$limit->down_limit&&$result<=$limit->up_limit)||($result==$limit->norma)){
                    $class = 'success';
                }
                else{
                    $class = 'danger';
                }
            }
            else{
                $class = 'warning';
            }


            
        }

        if($result===NULL){
            $class = 'warning';
        }

        return ['class'=>'bg-'.$class];
    }

    public static function getMin($main_id,$pokaz_id)
    {
        $limits = self::find()->where(['pokaz_id'=>$pokaz_id])->all();
        if(count($limits)>1){
            $dop = RegDopinfo::find()->where(['reg_id'=>$main_id,'indikator_id'=>$pokaz_id])->one();
            if($dop){
                $limit = self::findOne($dop->value);
                if($limit){
                    $res = $limit->down_limit;
                }
                else{
                    $res = 0;
                }
            }
            else{
                $res = 0;
            }
        }
        else{
            if(isset($limits[0])){
                $limit = $limits[0];
                if($limit){
                    $res = $limit->down_limit;
                }
                else{
                    $res = 0;
                }    
            }
            else{
                $res = 0;
            }
        }
        return $res;
    }

    public static function getNorma($main_id,$pokaz_id)
    {
        $limits = self::find()->where(['pokaz_id'=>$pokaz_id])->all();

        if(count($limits)>1){
            $dop = RegDopinfo::find()->where(['reg_id'=>$main_id,'indikator_id'=>$pokaz_id])->one();
            if($dop){
                $limit = self::findOne($dop->value);
                if($limit){
                    $res = $limit->norma;
                }
                else{
                    $res = 0;
                }
            }
            else{
                $res = 0;
            }
        }
        else{
            if(isset($limits[0])){
                $limit = $limits[0];
                if($limit){
                    $res = $limit->norma;
                }
                else{
                    $res = 0;
                }    
            }
            else{
                $res = 0;
            }
        }
        return $res;

    }

    public static function getMax($main_id,$pokaz_id)
    {
        $limits = self::find()->where(['pokaz_id'=>$pokaz_id])->all();
        if(count($limits)>1){
            $dop = RegDopinfo::find()->where(['reg_id'=>$main_id,'indikator_id'=>$pokaz_id])->one();
            if($dop){
                $limit = self::findOne($dop->value);
                if($limit){
                    $res = $limit->up_limit;
                }
                else{
                    $res = 0;
                }
            }
            else{
                $res = 0;
            }
        }
        else{
            if(isset($limits[0])){
                $limit = $limits[0];
                if($limit){
                    $res = $limit->up_limit;
                }
                else{
                    $res = 0;
                }    
            }
            else{
                $res = 0;
            }

        }
        return $res;
    }

    public static function getOneInfo($ind_id,$value,$reg_id)
    {
        $result = '';
        $client_model = Client::getClientByRegId($reg_id);
        if(strlen($client_model->birthdate)>4){
            $age = date('Y')-date('Y',strtotime($client_model->birthdate));   
        }
        else{
            $age = 1;
        }
        $models = self::find()->where(['pokaz_id'=>$ind_id])->all();
        $result.='<div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                              <div class="inner">';
        $result.="<p>".SPokazatel::getName($ind_id)."</p>";
                
                foreach ($models as $model) {

                    // $result.= "<label><input type='radio' name=pokaz[".$model->pokaz_id."] value='".$model->id."' checked /> ".$model->indikator.' - '.$model->indikator_value." ёшдан кичик {jinsi}</label><br>";;
                    $result.=PokazLimits::getUztextindikator($ind_id,$model->indikator,$model->indikator_value,$client_model->sex,$client_model->birthdate,$age,$model->id,0,$value);
                }
        $result.='</div>
                </div>
              </div>';
        return $result;
    }

    
}
