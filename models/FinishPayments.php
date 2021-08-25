<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "finish_payments".
 *
 * @property int $id
 * @property string $time
 * @property int $user_id
 */
class FinishPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finish_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'time', 'user_id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['time'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'user_id' => 'User ID',
        ];
    }
}
