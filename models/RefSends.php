<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_sends".
 *
 * @property int $id
 * @property string $refnum
 * @property int $sum
 * @property int $status
 * @property string $send_date
 * @property string|null $rec_date
 * @property int $user_id
 *
 * @property User $user
 */
class RefSends extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_sends';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['refnum', 'sum', 'status', 'send_date', 'user_id'], 'required'],
            [['sum', 'status', 'user_id', 'send_type'], 'integer'],
            [['send_date', 'rec_date'], 'safe'],
            [['refnum'], 'string', 'max' => 255],
            // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'refnum' => 'Врач',
            'sum' => 'Сумма',
            'status' => 'Статус',
            'send_date' => 'Жўнатиш сана',
            'send_type' => 'Тури',
            'rec_date' => 'Қабул қилган сана',
            'user_id' => 'Юборган ходим',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
}
