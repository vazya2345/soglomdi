<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "send_sms".
 *
 * @property int $id
 * @property string $number
 * @property string $sms_text
 * @property string $send_date
 * @property int $status
 */
class SendSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'send_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'sms_text', 'send_date'], 'required'],
            [['send_date'], 'safe'],
            [['status'], 'integer'],
            [['number'], 'string', 'max' => 255],
            [['sms_text'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'sms_text' => 'Sms Text',
            'send_date' => 'Send Date',
            'status' => 'Status',
        ];
    }

    public static function getLastDateForQarzByPhonenum($phone)
    {
        $model = self::find()->where(['number'=>$phone])->andWhere(['like', 'sms_text', '%qarz%', false])->orderBy(['id'=>SORT_DESC])->one();
        if($model)
            return $model->send_date;
        else
            return '';
    }
}
