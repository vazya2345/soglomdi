<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reagent_send".
 *
 * @property int $id
 * @property int $reagent_id
 * @property int $filial_id
 * @property int $soni
 * @property string|null $send_date
 * @property string|null $comment
 */
class ReagentSend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reagent_send';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reagent_id', 'filial_id', 'soni'], 'required'],
            [['reagent_id', 'filial_id', 'soni'], 'integer'],
            [['send_date'], 'safe'],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reagent_id' => 'Реагент',
            'filial_id' => 'Филиал',
            'soni' => 'Сони',
            'send_date' => 'Юборилган сана',
            'comment' => 'Изоҳ',
        ];
    }
}
