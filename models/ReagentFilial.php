<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reagent_filial".
 *
 * @property int $id
 * @property int $filial_id
 * @property int $reagent_id
 * @property int $qoldiq
 */
class ReagentFilial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reagent_filial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filial_id', 'reagent_id', 'qoldiq'], 'required'],
            [['filial_id', 'reagent_id', 'qoldiq'], 'integer'],
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
            'reagent_id' => 'Реагент',
            'qoldiq' => 'Қолдиқ(сони)',
        ];
    }

    public static function findByFilAndReagent($filial_id,$reagent_id)
    {
        $model = self::find()->where(['filial_id'=>$filial_id,'reagent_id'=>$reagent_id])->one();
        if($model)
            return $model;
        else
            return false;
    }
}
