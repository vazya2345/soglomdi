<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reagent_input".
 *
 * @property int $id
 * @property int $reagent_id
 * @property int $value
 * @property string $create_date
 * @property int $user_id
 */
class ReagentInput extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reagent_input';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reagent_id', 'value', 'create_date', 'user_id'], 'required'],
            [['reagent_id', 'value', 'user_id'], 'integer'],
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
            'reagent_id' => 'Реагент',
            'value' => 'Сони',
            'create_date' => 'Киритилган сана',
            'user_id' => 'Киритган ходим',
        ];
    }
}
