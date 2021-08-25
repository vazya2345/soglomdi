<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $title
 * @property string|null $group
 * @property string|null $add1
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'add1'], 'string', 'max' => 255],
            [['group'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Ном',
            'group' => 'Гурух',
            'add1' => 'Add1',
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
