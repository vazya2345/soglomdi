<?php

namespace app\modules\consultation\models;

use Yii;

/**
 * This is the model class for table "consultation_dori_recept".
 *
 * @property int $id
 * @property int|null $reg_id
 * @property string|null $dori_title
 * @property string|null $dori_doza
 * @property string|null $dori_shakli
 * @property string|null $dori_mahali
 * @property string|null $dori_davomiyligi
 * @property string|null $dori_qabul
 * @property string|null $dori_qayvaqtda
 * @property string|null $create_date
 * @property int|null $create_userid
 */
class ConsultationDoriRecept extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_dori_recept';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reg_id', 'create_userid'], 'integer'],
            [['create_date'], 'safe'],
            [['dori_title', 'dori_doza', 'dori_shakli', 'dori_mahali', 'dori_davomiyligi', 'dori_qabul', 'dori_qayvaqtda'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reg_id' => 'Регистрация',
            'dori_title' => 'Дори номи',
            'dori_doza' => 'Дозаси',
            'dori_shakli' => 'Шакли',
            'dori_mahali' => 'Махали',
            'dori_davomiyligi' => 'Давомийлиги(кун)',
            'dori_qabul' => 'Қабул тури',
            'dori_qayvaqtda' => 'Қай вақтда қабул қилиниши',
            'create_date' => 'Яратилган сана',
            'create_userid' => 'Яратган врач',
        ];
    }
}
