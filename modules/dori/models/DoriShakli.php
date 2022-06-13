<?php

namespace app\modules\dori\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "dori_shakli".
 *
 * @property int $id
 * @property string $title
 */
class DoriShakli extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dori_shakli';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
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
        ];
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = ArrayHelper::map($array, 'title', 'title');
        return $result;
    }
}
