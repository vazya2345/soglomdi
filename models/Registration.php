<?php

namespace app\models;

use Yii;
use app\models\Users;

/**
 * This is the model class for table "registration".
 *
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property int|null $sum_amount
 * @property int|null $sum_cash
 * @property int|null $sum_plastik
 * @property int|null $sum_debt
 * @property string|null $ref_code СЃРєРёРґРєР°
 * @property string|null $natija_input СЃС‚Р°С‚СѓСЃ РѕРїР»Р°С‚С‹
 * @property float|null $skidka
 * @property string|null $other
 * @property string|null $create_date
 * @property string|null $change_time
 */
class Registration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'user_id', 'ref_code', 'lab_vaqt', 'other'], 'required'],
            [['client_id', 'user_id', 'kassir_id', 'sum_amount', 'sum_cash', 'sum_plastik', 'sum_debt','status'], 'integer'],
            [['skidka_reg','skidka_kassa'], 'number'],
            [['create_date', 'change_time'], 'safe'],
            [['ref_code', 'natija_input', 'other', 'tashxis', 'lab_vaqt'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Мижоз',
            'user_id' => 'Фойдаланувчи',
            'sum_amount' => 'Нарх',
            'sum_cash' => 'Накд пул',
            'sum_plastik' => 'Пластик карта',
            'sum_debt' => 'Карз',
            'ref_code' => 'Реферал коди',
            'natija_input' => 'Натижа мавжудлиги',
            'skidka_reg' => 'Скидка рег',
            'skidka_kassa' => 'Скидка кассир',
            'other' => 'Проб. №',
            'create_date' => 'Қайд этилган вақт',
            'change_time' => 'Узгартириш вакти',
            'tashxis' => 'Ташхис',
            'lab_vaqt' => 'Натижа тайёр бўладиган тахминий вақт',
            'status'=>'Статус',
        ];
    }

    public static function getNatijaLink($id)
    {
        $model = self::findOne($id);
        $tolangan = $model->sum_cash+$model->sum_plastik+$model->skidka_reg+$model->skidka_kassa;
        // var_dump($tolangan);die;
        if($model->sum_amount<=$tolangan){
            return "<a href='?r=registration/result&id=".$id."'>Натижа</a>";
        }
        else{
            return "Тулов тулик амалга оширилмаган";
        }
    }

    public static function getIsPay($id)
    {
        $model = self::findOne($id);
        $tolangan = $model->sum_cash+$model->sum_plastik+$model->skidka_reg+$model->skidka_kassa;
        if($model->sum_amount<=$tolangan){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getSumForPay($id)
    {
        $model = self::findOne($id);
        $sum = 0;
        if($model){
            $sum = $model->sum_amount-$model->sum_cash-$model->sum_plastik-$model->skidka_reg-$model->skidka_kassa;
            return $sum;
        }
        else{
            return 0;
        }
    }

    public static function getClassForSum($id)
    {
        $fmodel = FinishPayments::findOne($id);
        if($fmodel){
            return ['class'=>'bg-success'];
        }
        else{
            return ['class'=>'bg-default'];   
        }
    }

    public static function getTashxisList()
    {
        $res = [
            'Профилактика' => 'Профилактика',
            'Четга чиқиш учун' => 'Четга чиқиш учун',
            'Симптом' => 'Симптом',
            'Истима' => 'Истима',
            'Йўтал' => 'Йўтал',
            'Холсизлик' => 'Холсизлик',
            'Таъм билмаслик' => 'Таъм билмаслик',
            'Нафас қисиши' => 'Нафас қисиши',
            'Мулоқот' => 'Мулоқот',
            'Тамоқ оғриғи' => 'Тамоқ оғриғи',
        ];
        return $res;
    }

    public static function getQarzSum()
    {
        if(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==9){
            $amount = self::find()->sum('sum_amount');
            $cash = self::find()->sum('sum_cash');
            $plastik = self::find()->sum('sum_plastik');
            // $debt = self::find()->sum('sum_debt');
            $kassa = self::find()->sum('skidka_kassa');
            $reg = self::find()->sum('skidka_reg');
            $res = $amount-$kassa-$reg-$cash-$plastik;
            return $res;
        }
        else{
            $amount = self::find()->where(['user_id'=>Yii::$app->user->id])->sum('sum_amount');
            $cash = self::find()->where(['user_id'=>Yii::$app->user->id])->sum('sum_cash');
            $plastik = self::find()->where(['user_id'=>Yii::$app->user->id])->sum('sum_plastik');
            // $debt = self::find()->where(['user_id'=>Yii::$app->user->id])->sum('sum_debt');
            $kassa = self::find()->where(['user_id'=>Yii::$app->user->id])->sum('skidka_kassa');
            $reg = self::find()->where(['user_id'=>Yii::$app->user->id])->sum('skidka_reg');
            $res = $amount-$kassa-$reg-$cash-$plastik;
            return $res;
        }
        return 0;
    }

    public static function getQarzSumFil($fil)
    {
        $user_arr = Users::getFilUsers($fil);
        $amount = self::find()->where(['in','user_id',$user_arr])->sum('sum_amount');
        $cash = self::find()->where(['in','user_id',$user_arr])->sum('sum_cash');
        $plastik = self::find()->where(['in','user_id',$user_arr])->sum('sum_plastik');
        $kassa = self::find()->where(['in','user_id',$user_arr])->sum('skidka_kassa');
        $reg = self::find()->where(['in','user_id',$user_arr])->sum('skidka_reg');
        $res = $amount-$kassa-$reg-$cash-$plastik;
        return $res;
    }

}
