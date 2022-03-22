<?php

namespace app\models;

use Yii;
use app\models\Reagent;
/**
 * This is the model class for table "reagent_notifications".
 *
 * @property int $id
 * @property int $reagent_id
 * @property int $filial_id
 * @property string $create_date
 */
class ReagentNotifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reagent_notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reagent_id', 'filial_id', 'create_date'], 'required'],
            [['reagent_id', 'filial_id'], 'integer'],
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
            'filial_id' => 'Филиал',
            'create_date' => 'Огохлантирилган сана',
        ];
    }

    public static function isReagent($reagent_id,$filial_id)
    {
        $model = self::find()->where(['reagent_id'=>$reagent_id, 'filial_id'=>$filial_id])->one();
        if($model){
            return true;
        }
        else{
            return false;
        }
    }
}
