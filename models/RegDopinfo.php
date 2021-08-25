<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reg_dopinfo".
 *
 * @property int $id
 * @property int $reg_id
 * @property int|null $indikator_id
 * @property string|null $value
 */
class RegDopinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reg_dopinfo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id'], 'required'],
            [['reg_id', 'indikator_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_id' => 'Руйхатдан утиш ID',
            'indikator_id' => 'Курсатгич',
            'value' => 'Киймат',
        ];
    }
}
