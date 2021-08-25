<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reg_reagents".
 *
 * @property int $id
 * @property int $reg_id
 * @property int $reagent_id
 * @property int $soni
 * @property int $filial_id
 * @property int $add1
 */
class RegReagents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reg_reagents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id', 'reagent_id', 'soni', 'filial_id'], 'required'],
            [['reg_id', 'reagent_id', 'soni', 'filial_id', 'add1'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_id' => 'Reg ID',
            'reagent_id' => 'Reagent ID',
            'soni' => 'Soni',
            'filial_id' => 'Filial ID',
            'add1' => 'Add1',
        ];
    }

    public static function getReagentCount($reagent_id,$reg_id)
    {
        $model = self::find()->where(['reg_id'=>$reg_id,'reagent_id'=>$reagent_id])->one();
        if($model){
            return $model->soni;
        }
        else{
            return 0;
        }
    }
}
