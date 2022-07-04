<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rasxod".
 *
 * @property int $id
 * @property int|null $filial_id
 * @property int|null $user_id
 * @property int $summa
 * @property int|null $sum_type
 * @property int|null $rasxod_type
 * @property string $rasxod_desc
 * @property string|null $rasxod_period
 * @property int|null $status
 * @property int $send_user
 *
 * @property Filials $filial
 * @property User $user
 */
class Rasxod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rasxod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filial_id', 'user_id', 'summa', 'sum_type', 'rasxod_type', 'status', 'send_user', 'referal_id', 'qabul_hodim_id'], 'integer'],
            [['summa'], 'required'],
            [['rasxod_desc'], 'string'],
            [['rasxod_period'], 'safe'],
            [['filial_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filials::className(), 'targetAttribute' => ['filial_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filial_id' => 'Филиал',
            'user_id' => 'Юборган ходим',
            'summa' => 'Сумма',
            'sum_type' => 'Нақд/Пластик',
            'rasxod_type' => 'Чиқим тури',
            'rasxod_desc' => 'Қўшимча маълумот',
            'rasxod_period' => 'Сана',
            'status' => 'Статус',
            'send_user' => 'Юборилган ходим',
            'referal_id' => 'Реферал',
            'create_date' => 'Яратилган сана',
            'mod_date' => 'Ўзгарган сана',
            'qabul_hodim_id' => 'Қабул қилган ходим',
        ];
    }

    /**
     * Gets query for [[Filial]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilial()
    {
        return $this->hasOne(Filials::className(), ['id' => 'filial_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
