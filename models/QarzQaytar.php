<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qarz_qaytar".
 *
 * @property int $id
 * @property int|null $reg_id
 * @property int|null $summa_plasitk
 * @property int|null $summa_naqd
 * @property string|null $qaytargan_vaqt
 * @property int|null $kassir_id
 */
class QarzQaytar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qarz_qaytar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id', 'summa_plasitk', 'summa_naqd', 'kassir_id'], 'integer'],
            [['qaytargan_vaqt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_id' => 'Регистрация',
            'summa_plasitk' => 'Сумма пластик',
            'summa_naqd' => 'Сумма нақд',
            'qaytargan_vaqt' => 'Қайтарилган вақт',
            'kassir_id' => 'Кассир',
        ];
    }

    public static function getMyModelByRegId($id)
    {
        $model = QarzQaytar::find()->where(['reg_id'=>$id])->one();
        if($model){
            return $model;
        }
        else{
            $model = new QarzQaytar();
            $model->reg_id = $id;
            $model->save(false);
            return $model;
        }
    }

    
}
