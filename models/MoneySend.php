<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "money_send".
 *
 * @property int $id
 * @property int $send_user
 * @property int $rec_user
 * @property int $amount
 * @property int $status
 * @property string $send_date
 * @property string $rec_date
 * @property int $desc
 * @property int $send_type
 */
class MoneySend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'money_send';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['send_user', 'rec_user', 'amount', 'send_date', 'rec_fq_id'], 'required'],
            [['send_user', 'rec_user', 'amount', 'status', 'rec_fq_id', 'send_type'], 'integer'],
            [['send_date', 'rec_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'send_user' => 'Юборган',
            'rec_user' => 'Қабул қилган',
            'rec_fq_id' => 'Касса',
            'amount' => 'Сумма',
            'status' => 'Статус',
            'send_date' => 'Юборилган вақт',
            'rec_date' => 'Қабул қилинган вақт',
            'desc' => 'Маълумот',
            'send_type' => 'Юбориш усули',
        ];
    }
}
