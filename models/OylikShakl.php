<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oylik_shakl".
 *
 * @property int $id
 * @property int $period
 * @property int $oylik_hodimlar_id
 * @property string $fio
 * @property string $fil_name
 * @property string $lavozim
 * @property string $title
 * @property int $summa
 * @property int $shakl_id
 *
 * @property OylikHodimlar $oylikHodimlar
 */
class OylikShakl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oylik_shakl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['period', 'oylik_hodimlar_id', 'fio', 'fil_name', 'title', 'summa', 'shakl_id'], 'required'],
            [['oylik_hodimlar_id', 'summa', 'shakl_id'], 'integer'],
            [['fio', 'fil_name', 'lavozim', 'title'], 'string', 'max' => 500],
            [['oylik_hodimlar_id'], 'exist', 'skipOnError' => true, 'targetClass' => OylikHodimlar::className(), 'targetAttribute' => ['oylik_hodimlar_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period' => 'Давр',
            'oylik_hodimlar_id' => 'Ходим',
            'fio' => 'Исм-шарифи',
            'fil_name' => 'Филиал',
            'lavozim' => 'Лавозим',
            'title' => 'Номи',
            'summa' => 'Сумма',
            'shakl_id' => 'Шакл',
        ];
    }

    /**
     * Gets query for [[OylikHodimlar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOylikHodimlar()
    {
        return $this->hasOne(OylikHodimlar::className(), ['id' => 'oylik_hodimlar_id']);
    }
}
