<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "s_analiz".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $price
 * @property int|null $is_active
 * @property int|null $ord
 * @property string|null $desc
 * @property string|null $add1
 * @property int|null $group_id
 *
 * @property VidAnaliz[] $vidAnalizs
 */
class SAnaliz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_analiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'is_active', 'is_fil', 'ord', 'group_id', 'lab_user_id'], 'integer'],
            [['desc'], 'string'],
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
            'price' => 'Нарх',
            'is_active' => 'Мавжудлиги',
            'ord' => 'Тартиб рақами',
            'desc' => 'Маълумот',
            'add1' => 'Гурух номи (пдф учун)',
            'group_id' => 'Гурух ID',
            'is_fil' => 'Филиал анализи',
            'lab_user_id' => 'Лаборант',
        ];
    }

    /**
     * Gets query for [[VidAnalizs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVidAnalizs()
    {
        return $this->hasMany(VidAnaliz::className(), ['analiz_id' => 'id']);
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = ArrayHelper::map($array, 'id', 'title');
        return $result;
    }

    public static function getAllPrice()
    {
        $array = self::find()->all();
        return $array;
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

    public static function isFil($id)
    {
        $model = self::findOne($id);
        if($model&&$model->is_fil==1){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getAdd1($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->add1;
        }
        else{
            return '';
        }
    }

    public static function getPrice($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->price;
        }
        else{
            return 0;
        }
    }

    public static function getAnalizsByAdd1($group)
    {
        $array = self::find()->select('id')->where(['add1'=>$group])->all();
        $result = ArrayHelper::map($array, 'id', 'id');
        return $result;
    }

    public static function getAnalizsByLabUserid($userid)
    {
        $array = self::find()->select('id')->where(['lab_user_id'=>$userid])->all();
        $result = ArrayHelper::map($array, 'id', 'id');
        return $result;
    }

    public static function getAnalizsByGroupid($groupid)
    {
        $array = self::find()->select('id')->where(['group_id'=>$groupid])->all();
        $result = ArrayHelper::map($array, 'id', 'id');
        return $result;
    }

    public static function getFilAnalizs()
    {
        $res = [];
        $i=0;
        $array = self::find()->select('id')->where(['is_fil'=>1])->all();
        foreach ($array as $key) {
            $res[$i]=$key->id;
            $i++;
        }
        return $res;
    }
}
