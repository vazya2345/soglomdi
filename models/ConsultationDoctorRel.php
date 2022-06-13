<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "consultation_doctor_rel".
 *
 * @property int $id
 * @property int|null $reg_id
 * @property int|null $consultation_doctor_id
 */
class ConsultationDoctorRel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_doctor_rel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id', 'consultation_doctor_id'], 'integer'],
            [['consultation_doctor_id'], 'required'],
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
            'consultation_doctor_id' => 'Кўрик ўтказувчи врач',
        ];
    }

    public static function getRegIds($doctor_id)
    {
        $models = ConsultationDoctorRel::find()->select('reg_id')->where(['consultation_doctor_id'=>$doctor_id])->asArray()->all();
        $result = ArrayHelper::map($models, 'reg_id', 'reg_id');
        return $result;
    }
}
