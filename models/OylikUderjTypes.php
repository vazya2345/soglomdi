<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "oylik_uderj_types".
 *
 * @property int $id
 * @property string $title
 */
class OylikUderjTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oylik_uderj_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'is_rasxod'], 'required'],
            [['is_rasxod'], 'integer'],
            [['title'], 'string', 'max' => 500],
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
            'is_rasxod' => 'Чиқим шаклланиши',
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
    }
}
