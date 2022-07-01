<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Filials;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $lavozim
 * @property int|null $role_id
 * @property int|null $active
 * @property string|null $login
 * @property string|null $password
 * @property string|null $mobile
 * @property string|null $info
 * @property string|null $img
 * @property string|null $other
 * @property string|null $add1
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'active'], 'integer'],
            [['info'], 'string'],
            [['name', 'lavozim', 'login', 'password', 'img', 'other', 'add1'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИШ',
            'lavozim' => 'Лавозими',
            'role_id' => 'Роль',
            'active' => 'Холати',
            'login' => 'Логин',
            'password' => 'Пароль',
            'mobile' => 'Телефон раками',
            'info' => 'Маълумотлари',
            'img' => 'Расм',
            'other' => 'Реферал коди',
            'add1' => 'Филиал',
        ];
    }
    
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function findIdentity($id)
    {
        return self::findOne($id) ? new static(self::findOne($id)) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        if(self::findOne($token)){
            return self::findOne($token);
        }
        else{
            return null;    
        }
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role_id;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->id === $authKey;
    }

    public static function getMyName()
    {
        $model = self::findOne(Yii::$app->user->id);
        if($model){
            return $model->name;
        }
        else{
            return 'Топилмади';
        }
    }

    public function getMyRole()
    {
        return $this->role_id;
    }

    public static function getMyLav()
    {
        $model = self::findOne(Yii::$app->user->id);
        if($model){
            return $model->lavozim;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getMyRefcode()
    {
        $model = self::findOne(Yii::$app->user->id);
        if($model){
            return $model->other;
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getAllKassirs()
    {
        $array = self::find()->where(['role_id'=>3])->all();
        $result = ArrayHelper::map($array, 'id', 'name');
        return $result;
    }

    public static function getAllIchkiNazorat()
    {
        $array = self::find()->where(['role_id'=>9])->all();
        $result = ArrayHelper::map($array, 'id', 'name');
        return $result;
    }

    public static function getAll()
    {
        $array = self::find()->all();
        $result = ArrayHelper::map($array, 'id', 'name');
        return $result;
    }

    public static function getAllLabs()
    {
        $array = self::find()->where(['role_id'=>4])->all();
        $result = ArrayHelper::map($array, 'id', 'name');
        return $result;
    }

    public static function getName($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->name;
        else
            return 'Топилмади';
    }

    public static function getNameAndFil($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->name.' - '.Filials::getName($model->add1);
        else
            return 'Топилмади';
    }

    public static function getMyFilUsers()
    {
        $model = self::findOne(Yii::$app->user->id);
        if($model){
            $emps = self::find()->where(['add1'=>$model->add1])->all();// filial boyicha filtr
            $result = ArrayHelper::map($emps, 'id', 'id');
            return $result;
        }
        else{
            return [];
        }
    }

    public static function getFilUsers($fil)
    {
        $emps = self::find()->where(['add1'=>$fil])->all();// filial boyicha filtr
        $result = ArrayHelper::map($emps, 'id', 'id');
        return $result;
    }

    public static function getFilUsersByUserId($userid)
    {
        $model = self::findOne($userid);
        $emps = self::find()->where(['add1'=>$model->add1])->all();// filial boyicha filtr
        $result = ArrayHelper::map($emps, 'id', 'id');
        return $result;
    }

    

    public static function getFilPhoneNum($id)
    {
        $model = self::findOne($id);
        if($model){
            $fil = Filials::findOne($model->add1);
            if($fil){
                return $fil->phone;
            }
            else{
                return 'Топилмади';
            }
        }
        else{
            return 'Топилмади';
        }
    }

    public static function getMyFil()
    {
        $model = self::findOne(Yii::$app->user->id);
        if($model){
            return $model->add1;
        }
        else{
            return false;
        }
    }

    public static function getFilial($id)
    {
        $model = self::findOne($id);
        if($model){
            return $model->add1;
        }
        else{
            return false;
        }
    }
    
    public static function getMyLogin()
    {
        $model = self::findOne(Yii::$app->user->id);
        if($model){
            return $model->login;
        }
        else{
            return false;
        }
    }

    public static function getConsultationDoctors()
    {
        $emps = self::find()->where(['role_id'=>10])->all();// filial boyicha filtr
        $result = ArrayHelper::map($emps, 'id', 'name');
        return $result;
    }

    public static function getNameVrach($id)
    {
        $model = self::findOne($id);
        if($model)
            return $model->lavozim.' '.$model->name;
        else
            return 'Топилмади';
    }

    public static function getZavkassa()
    {
        $emps = self::find()->where(['role_id'=>6])->one();// filial boyicha filtr
        if($emps){
            return $emps->id;
        }
        else{
            return 1;
        }
    }

    public static function getAllWithFil()
    {
        $array = [];
        $models = self::find()->orderBy(['add1'=>SORT_ASC])->all();
        foreach ($models as $model) {
            $array[$model->id] = $model->name.' - '.Filials::getName($model->add1);
        }

        return $array;
    }
}

