<?php

namespace app\modules\dori\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "dori_list".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $doza
 * @property string|null $shakli
 * @property string|null $qabul
 * @property string|null $info
 */
class DoriList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dori_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'doza', 'shakli', 'qabul', 'info'], 'string', 'max' => 255],
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
            'doza' => 'Доза',
            'shakli' => 'Шакли',
            'qabul' => 'Қабул қилиш',
            'info' => 'Қўшимча маълумот',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = [];
        foreach ($array as $key) {
            $result[$key->id] = $key->title.' - '.$key->doza.' - '.$key->shakli.' - '.$key->qabul;
        }
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
