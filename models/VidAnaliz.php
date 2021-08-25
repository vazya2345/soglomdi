<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vid_analiz".
 *
 * @property int $id
 * @property int $analiz_id
 * @property string|null $title
 * @property string|null $sec_text
 * @property int|null $type
 * @property int|null $ord
 * @property string|null $add1
 * @property string|null $ed_izm
 * @property string|null $kolkach
 *
 * @property SAnaliz $analiz
 */
class VidAnaliz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vid_analiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['analiz_id'], 'required'],
            [['analiz_id', 'type', 'ord'], 'integer'],
            [['title', 'sec_text', 'add1', 'ed_izm', 'kolkach'], 'string', 'max' => 255],
            [['analiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => SAnaliz::className(), 'targetAttribute' => ['analiz_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'analiz_id' => 'Тахлил ID',
            'title' => 'Номланиши',
            'sec_text' => 'Sec Text',
            'type' => 'Тури',
            'ord' => 'Буюртма',
            'add1' => 'Add1',
            'ed_izm' => 'Улчов бирлиги',
            'kolkach' => 'Микдор/Сифат',
        ];
    }

    /**
     * Gets query for [[Analiz]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnaliz()
    {
        return $this->hasOne(SAnaliz::className(), ['id' => 'analiz_id']);
    }
}
