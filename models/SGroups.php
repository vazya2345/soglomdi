<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "s_groups".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $ord
 * @property int|null $active
 */
class SGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ord', 'active', 'add1'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'ord' => 'Тартиби',
            'active' => 'Активлиги',
            'add1' => 'Регистрация ойнасида очиқлиги',
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
        if($model)
            return $model->title;
        else
            return 'Топилмади';
    }
}
