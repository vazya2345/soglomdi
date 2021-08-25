<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $main_id
 * @property int $cash_sum
 * @property int $plastik_sum
 * @property string $create_date
 * @property int $kassir_id
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id', 'cash_sum', 'plastik_sum', 'create_date', 'kassir_id'], 'required'],
            [['main_id', 'cash_sum', 'plastik_sum', 'kassir_id'], 'integer'],
            [['create_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_id' => 'Регистрация ИД',
            'cash_sum' => 'Нақд пул',
            'plastik_sum' => 'Пластик',
            'create_date' => 'Сана',
            'kassir_id' => 'Кассир ИД',
        ];
    }
}
