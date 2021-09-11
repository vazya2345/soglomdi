<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "s_rasxod_types".
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 */
class SRasxodTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_rasxod_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'required'],
            [['desc'], 'string'],
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
            'title' => 'Title',
            'desc' => 'Desc',
        ];
    }
}
