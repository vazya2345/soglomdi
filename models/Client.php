<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Registration;
/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string|null $fname
 * @property string|null $lname
 * @property string|null $mname
 * @property string|null $birthdate
 * @property string|null $sex
 * @property string|null $doc_seria
 * @property string|null $doc_number
 * @property string|null $inn
 * @property string|null $add1
 * @property string|null $type
 * @property int|null $user_id
 * @property string|null $create_date
 * @property string|null $change_date
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birthdate', 'create_date', 'change_date'], 'safe'],
            [['user_id'], 'integer'],
            [['fname', 'lname', 'mname', 'add1', 'type', 'address_tuman'], 'string', 'max' => 255],
            [['address_text'], 'string', 'max' => 600],
            [['sex'], 'string', 'max' => 1],
            [['doc_seria'], 'string', 'max' => 10],
            [['doc_number', 'inn'], 'string', 'max' => 20],
            [['birthdate', 'fname'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lname' => 'Фамилия',
            'fname' => 'Имя',
            'mname' => 'Отасининг исми',
            'birthdate' => 'Тугилган йили',
            'sex' => 'Жинси',
            'doc_seria' => 'Хужжат серияси',
            'doc_number' => 'Хужжат раками',
            'inn' => 'ИНН',
            'add1' => 'Телефон рақами',
            'type' => 'Тур',
            'user_id' => 'User ID',
            'create_date' => 'Яратилган сана',
            'change_date' => 'Узгартирилган сана',
            'address_tuman' => 'Адрес (туман/шахар)',
            'address_text' => 'Адрес (куча/уй)',
        ];
    }

    public static function getClientByDoc($doc_seria,$doc_number)
    {
        if(strlen($doc_seria)==0){
            return false;
        }
        $model = self::find()->where(['doc_seria'=>$doc_seria,'doc_number'=>$doc_number])->one();
        if($model){
            return $model;
        }
        else{
            return false;
        }
    }

    public static function getClientByNameAndBirth($lname,$fname,$birthdate)
    {
        $model = self::find()->where(['lname'=>$lname,'fname'=>$fname,'birthdate'=>$birthdate])->one();
        if($model){
            return $model;
        }
        else{
            return false;
        }
    }

    

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->lname.' '.$model->fname.' '.$model->mname;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getPhonenum($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->add1;
        }
        else{
            return 'Топилмади';
        }
    }
    public static function getPhonenumforsms($id)
    {
        $model = self::findOne($id);
        if($model){
            $res = str_replace('+','',$model->add1);
            $check = substr($res,0,3);
            if($check=='998'&&strlen($res)==12){
                return $res;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function getBirthDate($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->birthdate;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getArrayByFio($text)
    {
        $models = self::find()->select('id')->where(['like','lname',$text])->orWhere(['like','fname',$text])->all();
        // var_dump($models);die;
        $ids = ArrayHelper::getColumn($models, 'id');
        return $ids;
    }

    public static function getClientByRegId($reg_id)
    {
        $reg = Registration::findOne($reg_id);
        if($reg){
            $model = self::findOne($reg->client_id);
            if($model){
                return $model;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function getClientNameByRegId($reg_id)
    {
        $reg = Registration::findOne($reg_id);
        if($reg){
            $model = self::findOne($reg->client_id);
            if($model){
                return $model->lname.' '.$model->fname;
            }
            else{
                return 'Топилмади';
            }
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getAll()
    {
        $array = self::find()->where(['user_id'=>Yii::$app->user->id])->all();
        $result = [];
        foreach ($array as $key) {
            $result[$key->id] = $key->lname.' '.$key->fname.' '.$key->mname.' '.$key->doc_seria.$key->doc_number;
        }
        return $result;
    }
    
}
