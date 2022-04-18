<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "filials".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $adress
 * @property string|null $phone
 * @property string|null $add1
 * @property string|null $add2
 */
class Filials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adress'], 'string'],
            [['title', 'phone', 'add1', 'add2', 'chek_nomi', 'chek_lozung'], 'string', 'max' => 255],
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
            'adress' => 'Адреси',
            'phone' => 'Телефон раками',
            'add1' => 'СМС юбормаслик',
            'add2' => 'Add2',
            'chek_nomi' => 'Чекдаги номи',
            'chek_lozung' => 'Чекдаги гап'
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
            if($id==777){
                return 'Склад';
            }
            else{
                return 'Топилмади';
            }
        }
    }

    public static function getPhone($id)
    {
        // var_dump($id);die;
        $model = self::findOne($id);
        // var_dump($model->phone);die;
        if($model)
            return $model->phone;
        else
            return '95-204-01-50';
    }
}
