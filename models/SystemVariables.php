<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_variables".
 *
 * @property string $uid
 * @property string $value
 */
class SystemVariables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_variables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'value'], 'required'],
            [['uid', 'value'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Код',
            'value' => 'Қиймати',
        ];
    }
}
