<?php

namespace app\modules\consultation\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "consultation_tashhis_list".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $info
 * @property string|null $group
 */
class ConsultationTashhisList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_tashhis_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['info'], 'string'],
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
