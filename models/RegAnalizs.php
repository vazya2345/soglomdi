<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\SAnaliz;
/**
 * This is the model class for table "reg_analizs".
 *
 * @property int $id
 * @property int|null $reg_id
 * @property int|null $analiz_id
 * @property int|null $summa
 */
class RegAnalizs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reg_analizs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id', 'analiz_id', 'summa'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_id' => 'Reg ID',
            'analiz_id' => 'Analiz ID',
            'summa' => 'Summa',
        ];
    }

    public static function getAnalizsByGroup($group,$reg_id)
    {
        $array = RegAnalizs::find()->where(['reg_id'=>$reg_id, 'analiz_id'=>SAnaliz::getAnalizsByAdd1($group)])->all();
        $result = ArrayHelper::map($array, 'analiz_id', 'analiz_id');
        return $result;
    }

    public static function getAnalizsNamesByRegId($reg_id)
    {
        $models = RegAnalizs::find()->where(['reg_id' => $reg_id])->orderBy(['id' => SORT_ASC])->all();
        $res='';
        foreach($models as $model){
            $res.=SAnaliz::getName($model->analiz_id).'
';
        }
        return $res;
    }
    public static function getAnalizsCostsByRegId($reg_id)
    {
        $models = RegAnalizs::find()->where(['reg_id'=>$reg_id])->orderBy(['id' => SORT_ASC])->all();
        $res='';
        foreach($models as $model){
            $res.=SAnaliz::getPrice($model->analiz_id).'
';
        }
        return $res;
    }

    public static function getRegIds($analiz_id)
    {
        $models = RegAnalizs::find()->select('reg_id')->where(['analiz_id'=>$analiz_id])->asArray()->all();
        $result = ArrayHelper::map($models, 'reg_id', 'reg_id');
        return $result;
    }

    public static function getRegIdsByAnalizsArray($analiz_array)
    {
        $res = [];
        $i=0;
        $models = RegAnalizs::find()->select('reg_id')->where(['in','analiz_id',$analiz_array])->asArray()->all();
        $res = ArrayHelper::map($models, 'reg_id', 'reg_id');
        // foreach ($models as $key) {
        //     $res[$i]=$key->id;
        //     $i++;
        // }
        return $res;
    }

    public static function getAnalizIdsByRegId($reg_id)
    {
        $reg_analizs = RegAnalizs::find()->where(['reg_id'=>$reg_id])->asArray()->all();
        $res = [];
        $i=0;
        foreach ($reg_analizs as $key) {
            $res[$i] = $key['analiz_id'];
            $i++;
        }
        return $res;
    }
}
