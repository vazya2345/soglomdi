<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eslatma".
 *
 * @property int $id
 * @property string $eslatma_text
 */
class Eslatma extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eslatma';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['eslatma_text'], 'required'],
            [['eslatma_text'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eslatma_text' => 'Эслатма матни',
        ];
    }
}
