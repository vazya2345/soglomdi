<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "inp_types".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $add1
 * @property int|null $ord
 */
class InpTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inp_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ord'], 'integer'],
            [['title', 'add1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Номи',
            'add1' => 'Маълумот',
            'ord' => 'Сортировка',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = ArrayHelper::map($array, 'id', 'title');
        return $result;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->title;
        }
        else{
            return 'Топилмади';
        }
    }
}
