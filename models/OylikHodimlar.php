<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oylik_hodimlar".
 *
 * @property int $id
 * @property string $fio
 * @property int $summa
 * @property int $filial_id
 * @property int $lavozim
 * @property string $other_info
 * @property string $create_date
 *
 * @property Filials $filial
 * @property OylikShakl[] $oylikShakls
 * @property OylikUderj[] $oylikUderjs
 */
class OylikHodimlar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oylik_hodimlar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'summa', 'filial_id'], 'required'],
            [['summa', 'filial_id'], 'integer'],
            [['create_date'], 'safe'],
            [['fio', 'other_info', 'lavozim'], 'string', 'max' => 500],
            [['filial_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filials::className(), 'targetAttribute' => ['filial_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Исм-шарифи',
            'summa' => 'Оклади',
            'filial_id' => 'Филиал',
            'lavozim' => 'Лавозими',
            'other_info' => 'Бошка маълумот',
            'create_date' => 'Яратилган сана',
        ];
    }

    /**
     * Gets query for [[Filial]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilial()
    {
        return $this->hasOne(Filials::className(), ['id' => 'filial_id']);
    }

    /**
     * Gets query for [[OylikShakls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOylikShakls()
    {
        return $this->hasMany(OylikShakl::className(), ['oylik_hodimlar_id' => 'id']);
    }

    /**
     * Gets query for [[OylikUderjs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOylikUderjs()
    {
        return $this->hasMany(OylikUderj::className(), ['oylik_hodimlar_id' => 'id']);
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = [];
        foreach ($array as $key) {
            $result[$key->id] = $key->fio;
        }
        return $result;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->fio;
        }
    }
}
 