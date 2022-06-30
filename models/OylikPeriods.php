<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "oylik_periods".
 *
 * @property string $period
 */
class OylikPeriods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oylik_periods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['period'], 'required'],
            [['period'], 'safe'],
            [['period'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'period' => 'Давр',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->orderBy(['period'=>SORT_DESC])->all();
        $result = ArrayHelper::map($array, 'period', 'period');
        return $result;
    }

    public static function getActivePeriod()
    {
        $model = self::find()->orderBy(['period'=>SORT_DESC])->one();
        if($model){
            return  $model->period;
        }
        else{
            return date("d.m.Y", strtotime('first day of this month', time())); 
        }
    }


}
