<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Users;
use app\models\Registration;
/**
 * This is the model class for table "referals".
 *
 * @property int $id
 * @property string $fio
 * @property string|null $phone
 * @property int|null $user_id
 * @property string|null $desc
 * @property string|null $info
 * @property string|null $add1
 * @property string|null $refnum
 */
class Referals extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio','refnum'], 'required'],
            [['user_id','avans_sum','filial','fix_sum'], 'integer'],
            [['refnum'], 'unique'],
            [['info'], 'string'],
            [['fio', 'phone', 'desc', 'add1', 'refnum'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИШ',
            'phone' => 'Телефон',
            'user_id' => 'Фойдаланувчи',
            'desc' => 'Шифохона номи',
            'info' => 'Лавозими, булим номи',
            'add1' => 'Фоизи',
            'refnum' => 'Коди',
            'avans_sum' => 'Аванс суммаси',
            'plastik_number' => 'Пластик рақами',
            'plastik_date' => 'Пластик санаси',
            'plastik_name' => 'Пластик эгаси',
            'create_date' => 'Яратилган сана',
            'qoldiq_summa' => 'Қолдиқ сумма',
            'last_change_date' => 'Охирги узгарган сана',
            'filial' => 'Филиал',
            'fix_sum' => 'Фикс сумма',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $res = [];
        foreach ($array as $key) {
            $res[$key->refnum] = $key->refnum.' - '.$key->fio;
        }
        return $res;
    }

    public static function getAllId()
    {
        $array = self::find()->all();
        $res = [];
        foreach ($array as $key) {
            $res[$key->id] = $key->refnum.' - '.$key->fio;
        }
        return $res;
    }


    public static function getByRefnum($refnum)
    {
        $model = self::find()->where(['refnum'=>$refnum])->one();
        if($model){
            return $model;
        }
        else{
            return null;
        }
    }

    public static function getMyRefCode()
    {
        $model = self::find()->where(['refnum'=>Users::getMyRefcode()])->one();
        if($model){
            return $model->refnum;
        }
        else{
            return null;
        }
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->fio;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getFilial($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->filial;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getFilialByRefnum($refnum)
    {
        $model = self::find()->where(['refnum'=>$refnum])->one();
        if($model){
            return $model->filial;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getNameByRefnum($refcode)
    {
        $model = self::find()->where(['refnum'=>$refcode])->one();
        if($model){
            return $model->fio;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getHospital($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->desc;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getPhone($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->phone;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getAdd1($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->add1;
        }
        else{
            return 0;
        }
    }

    public static function getPhonenumByRefnum($refnum)
    {
        $model = self::find()->where(['refnum'=>$refnum])->one();
        
        if($model){
            if(strlen($model->phone)>=12){
                $res = str_replace('+','',$model->phone);
                $res = str_replace('-','',$res);
                $res = str_replace('(','',$res);
                $res = str_replace(')','',$res);
                return $res;
            }
            else{
                return '998000000000';
            }
        }
        else{
            return '998000000000';
        }
    }


    public static function getSumByRegid($id)
    {
        $reg = Registration::findOne($id);
        $model = self::getByRefnum($reg->ref_code);
        if($model){
            if((int)$model->add1>0){
                if($reg->skidka_reg>0||$reg->skidka_kassa>0||$reg->sum_debt>0){
                    return 0;
                }
                else{
                    $sum = ($reg->sum_cash+$reg->sum_plastik)*$model->add1/100;
                    return $sum;
                }
            }
            else{
                return $model->fix_sum;
            }
        }
        else{
            return 0;
        }
    }
    


}
