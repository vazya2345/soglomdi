<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Filials;
/**
 * This is the model class for table "filial_qoldiq".
 *
 * @property int $id
 * @property int $filial_id
 * @property int|null $kassir_id
 * @property int|null $qoldiq
 * @property string|null $last_change_date
 */
class FilialQoldiq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filial_qoldiq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filial_id'], 'required'],
            [['filial_id', 'kassir_id', 'qoldiq'], 'integer'],
            [['last_change_date'], 'safe'],
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
            'kassir_id' => 'Кассир',
            'qoldiq' => 'Қолдиқ',
            'last_change_date' => 'Охирги ўзгарган сана',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->where(['not in','kassir_id',[4]])->all();

        $res1 = [];
        foreach ($array as $key) {
            $res1[$key->id]=Filials::getName($key->filial_id).' - '.$key->kassir_id;
        }
        return $res1;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model)
            return Filials::getName($model->filial_id).' - '.$model->kassir_id;
        else
            return 'Топилмади';
    }
}
