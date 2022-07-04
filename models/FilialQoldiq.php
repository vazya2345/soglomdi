<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Filials;
use app\models\MoneySend;
use app\models\Rasxod;
use app\models\Payments;
use app\models\FqSends;
use app\models\Users;

/**
 * This is the model class for table "filial_qoldiq".
 *
 * @property int $id
 * @property int $filial_id
 * @property int|null $kassir_id
 * @property int|null $qoldiq
 * @property string|null $last_change_date
 */
class FilialQoldiq extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filial_qoldiq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filial_id'], 'required'],
            [['filial_id', 'kassir_id', 'qoldiq', 'qoldiq_type'], 'integer'],
            [['last_change_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filial_id' => 'Филиал',
            'kassir_id' => 'Кассир',
            'qoldiq' => 'Қолдиқ',
            'qoldiq_type' => 'Тури',
            'last_change_date' => 'Охирги ўзгарган сана',
        ];
    }

    public static function getAll()
    {
        $array = self::find()->where(['not in','kassir_id',[4]])->orderBy(['kassir_id'=>SORT_ASC])->all();

        $res1 = [];
        foreach ($array as $key) {
            $res1[$key->id]=Filials::getName($key->filial_id).'-'.Users::getName($key->kassir_id).'-'.$key->qoldiq_type;
        }
        return $res1;
    }

    public static function getFilQoldiqs($fil)
    {
        $fqs = self::find()->where(['filial_id'=>$fil])->andWhere(['not in', 'kassir_id', [1,17,36,37]])->all();// filial boyicha filtr
        $result = ArrayHelper::map($fqs, 'id', 'id');
        return $result;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model)
            return Filials::getName($model->filial_id).' - '.Users::getName($model->kassir_id).' - '.$model->qoldiq_type;
        else
            return 'Топилмади';
    }

    public static function getListForSendMoney()
    {
        $array = self::find()->where(['not in','kassir_id',[4]])->orderBy(['filial_id'=>SORT_ASC])->all();

        $res1 = [];
        $arr = [1=>'Нақд',2=>'Пластик'];
        foreach ($array as $key) {
            $res1[$key->id]=Filials::getName($key->filial_id).' - '.Users::getName($key->kassir_id).' - '.$arr[$key->qoldiq_type];
        }
        return $res1;
    }

    public static function getMyBalanceText()
    {
        $type_arr = [1=>'Нақд', 2=>'Платсик'];
        $sum = '';
        $models = self::find()->where(['kassir_id'=>Yii::$app->user->getId()])->all();
        // var_dump($models);die;
        foreach ($models as $model) {
            $sum.= $type_arr[$model->qoldiq_type].': '.number_format($model->qoldiq).' сўм. ';
        }
        return $sum;
    }

    public static function getMyBalance()
    {
        $sum = 0;
        $models = self::find()->where(['kassir_id'=>Yii::$app->user->getId()])->all();
        foreach ($models as $model) {
            $sum+=$model->qoldiq;
        }
        return $sum;
    }

    public static function checkBalance($kassir_id,$type)
    {
        $model = self::find()->where(['kassir_id'=>$kassir_id,'qoldiq_type'=>$type])->one();
        if($model){
            return $model->qoldiq;
        }
        else{
            return 0;
        }
    }

    public static function checkOperationsByMoney($kassir_id)
    {
        $rasxod_model = Rasxod::find()->where(['user_id'=>$kassir_id, 'status'=>1])->one();
        if($rasxod_model){
            return false;
        }
        else{
            $ms_model = MoneySend::find()->where(['send_user'=>$kassir_id, 'status'=>1])->one();
            if($ms_model){
                return false;
            }
            else{
                return true;
            }
        }
    }

    public static function hisobAllTypesByKassirId($id){
        $models = self::find()->where(['kassir_id'=>$id])->all();
        foreach ($models as $key) {
            self::hisob($key->id);
        }
    }

    public static function hisob($id)
    {
        $sum = 0;
        $model = self::findOne($id);
        if($model->kassir_id!=17&&$model->kassir_id!=1){
            if($model->qoldiq_type==1){
                $regs = Payments::find()
                ->select('sum(IFNULL(cash_sum, 0)) AS `s_amount`')
                ->where(['>','create_date',$model->last_change_date])
                ->andWhere(['kassir_id'=>$model->kassir_id])
                ->asArray()
                ->all();
            }
            else{
                $regs = Payments::find()
                ->select('sum(IFNULL(plastik_sum, 0)) AS `s_amount`')
                ->where(['>','create_date',$model->last_change_date])
                ->andWhere(['kassir_id'=>$model->kassir_id])
                ->asArray()
                ->all();
            }
            
            if($regs[0]['s_amount']){
                $sum = $regs[0]['s_amount'];
            }
            else{
                $sum = 0;    
            }
            $model->qoldiq = (int)abs($model->qoldiq) + (int)$sum;

        }
        else{
            if($model->kassir_id==17){
                $regs = FqSends::find()->select('sum(IFNULL(sum, 0)) AS `s_amount`')
                ->where(['>','rec_date',$model->last_change_date])
                ->andWhere(['status'=>2])
                ->andWhere(['send_type'=>$model->qoldiq_type])
                ->andWhere(['not in','fq_id',[8,28,44,45]])
                ->asArray()
                ->all();

                if($regs[0]['s_amount']){
                    $sum = $regs[0]['s_amount'];
                }
                else{
                    $sum = 0;    
                }
                $model->qoldiq = (int)$model->qoldiq + (int)$sum;
            }
            elseif($model->kassir_id==1){
                // var_dump($model);die;
                $regs = FqSends::find()->select('sum(IFNULL(sum, 0)) AS `s_amount`')
                ->where(['>','rec_date',$model->last_change_date])
                ->andWhere(['status'=>2])
                ->andWhere(['send_type'=>$model->qoldiq_type])
                ->andWhere(['in','fq_id',[8,28]])
                ->asArray()
                ->all();

                if($regs[0]['s_amount']){
                    $sum = $regs[0]['s_amount'];
                }
                else{
                    $sum = 0;    
                }
                $model->qoldiq = (int)$model->qoldiq + (int)$sum;
            }
        }

        $model->last_change_date = date("Y-m-d H:i:s");
        if($model->save()){
            return true;
        }
        else{
            var_dump($model->errors);
            return false;
        }

        
    }


    public static function getFilQozonUser($fil)
    {

        if($fil!=1){
            $fqs = self::find()->where(['filial_id'=>$fil])->orderBy(['qoldiq'=>SORT_DESC])->one();
            if($fqs){
                return $fqs->kassir_id;
            }
            else{
                return Users::getZavkassa();
            }
        }
        else{
            return Users::getZavkassa();
        }
    }
}
