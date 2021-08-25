<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_pokazatel".
 *
 * @property int $id
 * @property string $title
 * @property int $analiz_id
 * @property string|null $add1
 * @property int|null $ord
 */
class SPokazatel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_pokazatel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'analiz_id'], 'required'],
            [['analiz_id', 'ord', 'inptype_id'], 'integer'],
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
            'title' => 'Номланиши',
            'analiz_id' => 'Тахлил ID',
            'add1' => 'Ўлчов бирлиги',
            'ord' => 'Буюртма',
            'inptype_id' => 'Маълумот тўлдирилиши',
        ];
    }


    public static function getPokazs($analiz_id)
    {
        $model = self::find()->where(['analiz_id'=>$analiz_id])->all();
        return $model;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->title;
        else
            return 'Топилмади';
    }

    public static function getInpType($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->inptype_id;
        else
            return 1;
    }

    public static function getAdd1UlchBirligi($id)
    {
        $model = self::findOne($id);
        if($model){
            if($model->add1==''){
                return '-';
            }
            else{
                return $model->add1;
            }
        }
        else
            return '-';
    }
}
