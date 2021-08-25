<?php

namespace app\models;

use Yii;
use app\models\Reagent;
/**
 * This is the model class for table "reagent_rel".
 *
 * @property int $id
 * @property int $reagent_id
 * @property int $analiz_id
 * @property int $soni
 */
class ReagentRel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reagent_rel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reagent_id', 'analiz_id', 'soni'], 'required'],
            [['reagent_id', 'analiz_id', 'soni'], 'integer'],
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
            'analiz_id' => 'Анализ',
            'soni' => 'Сони',
        ];
    }

    public static function getReagentsForAnaliz($analiz_id)
    {
        $arr = Reagent::getBirMartaArray();
        $models = self::find()->where(['analiz_id'=>$analiz_id])->andWhere(['not in', 'reagent_id', $arr])->all();
        if($models)
            return $models;
        else
            return false;
    }

    public static function checkReagentsByAnalizId($analiz_id)
    {
        $models = self::find()->where(['analiz_id'=>$analiz_id])->all();
        if($models)
            return $models;
        else
            return false;
    }

    
}
