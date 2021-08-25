<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fq_sends".
 *
 * @property int $id
 * @property int $fq_id
 * @property int $sum
 * @property int $status
 * @property string|null $send_date
 * @property string|null $rec_date
 */
class FqSends extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fq_sends';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fq_id', 'sum', 'status'], 'required'],
            [['fq_id', 'sum', 'status'], 'integer'],
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
            'fq_id' => 'Касса ИД',
            'sum' => 'Сумма',
            'status' => 'Статус',
            'send_date' => 'Жўнатилган сана',
            'rec_date' => 'Қабул қилинган сана',
        ];
    }
}
