<?php

namespace app\modules\consultation\models;

use Yii;

/**
 * This is the model class for table "consultation_main".
 *
 * @property int $id
 * @property int|null $reg_id
 * @property string|null $consultation_type
 * @property string|null $value
 */
class ConsultationMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id'], 'integer'],
            [['value'], 'string'],
            [['consultation_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_id' => 'Регистрация',
            'consultation_type' => 'Консультация тури',
            'value' => 'Қиймати',
        ];
    }


    public static function getArrayChecked($type, $reg_id){
        $result = [];
        $i=0;
        $models = self::find()->select('value')->where(['consultation_type'=>$type, 'reg_id'=>$reg_id])->asArray()->all();
        foreach ($models as $key) {
            $result[$i] = $key['value'];
            $i++;
        }
        return $result;
    }
}
