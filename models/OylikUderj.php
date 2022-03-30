<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oylik_uderj".
 *
 * @property int $id
 * @property int $oylik_hodimlar_id
 * @property string $title
 * @property int $summa
 * @property int $period
 * @property string $create_date
 * @property int $create_userid
 *
 * @property OylikHodimlar $oylikHodimlar
 * @property User $createUser
 */
class OylikUderj extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oylik_uderj';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oylik_hodimlar_id', 'title', 'summa', 'period'], 'required'],
            [['oylik_hodimlar_id', 'summa', 'create_userid'], 'integer'],
            [['create_date'], 'safe'],
            [['title'], 'string', 'max' => 500],
            // [['oylik_hodimlar_id'], 'exist', 'skipOnError' => true, 'targetClass' => OylikHodimlar::className(), 'targetAttribute' => ['oylik_hodimlar_id' => 'id']],
            // [['create_userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['create_userid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oylik_hodimlar_id' => 'Ходим',
            'title' => 'Ушланма тури',
            'summa' => 'Сумма',
            'period' => 'Давр',
            'create_date' => 'Ярартилган сана',
            'create_userid' => 'Яратган ходим',
        ];
    }

    /**
     * Gets query for [[OylikHodimlar]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOylikHodimlar()
    {
        return $this->hasOne(OylikHodimlar::className(), ['id' => 'oylik_hodimlar_id']);
    }


}
