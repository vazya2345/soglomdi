<?php

namespace app\modules\consultation\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "consultation_operation_list".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $info
 * @property string|null $group
 * @property int|null $price
 */
class ConsultationOperationList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_operation_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info'], 'string'],
            [['price'], 'integer'],
            [['title', 'group'], 'string', 'max' => 255],
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
            'info' => 'Маълумот',
            'group' => 'Группа',
            'price' => 'Нархи',
        ];
    }
    
    public static function getAll()
    {
        $array = self::find()->all();
        $result = ArrayHelper::map($array, 'title', 'title');
        return $result;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->title;
        }
        else{
            return '';
        }
    }
}
