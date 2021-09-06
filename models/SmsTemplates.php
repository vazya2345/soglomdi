<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sms_templates".
 *
 * @property int $id
 * @property string $code
 * @property string $sms_text
 */
class SmsTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'sms_text'], 'required'],
            [['code', 'sms_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'sms_text' => 'Sms Text',
        ];
    }
}
