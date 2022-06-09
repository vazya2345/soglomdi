<?php

namespace app\modules\dori\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "dori_davomiyligi".
 *
 * @property int $id
 * @property string|null $value
 */
class DoriDavomiyligi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dori_davomiyligi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Қиймати',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = ArrayHelper::map($array, 'value', 'value');
        return $result;
    }
}
