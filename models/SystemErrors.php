<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_errors".
 *
 * @property int $id
 * @property string $err_action
 * @property string $err_msg
 * @property string $create_date
 */
class SystemErrors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_errors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['err_action', 'err_msg', 'create_date'], 'required'],
            [['err_msg'], 'string'],
            [['create_date'], 'safe'],
            [['err_action'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'err_action' => 'Err Action',
            'err_msg' => 'Err Msg',
            'create_date' => 'Create Date',
        ];
    }
}
