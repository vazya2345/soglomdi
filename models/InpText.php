<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "inp_text".
 *
 * @property int $id
 * @property int|null $inptype_id
 * @property string|null $input_type html input type
 * @property string|null $input_value
 * @property string|null $add1
 * @property int|null $ord
 */
class InpText extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inp_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inptype_id', 'ord'], 'integer'],
            [['input_type'], 'string', 'max' => 50],
            [['input_value', 'add1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inptype_id' => 'Маълумот киритиш тури',
            'input_type' => 'Маълумот тури',
            'input_value' => 'Қиймати',
            'add1' => 'Add1',
            'ord' => 'Сортировка',
        ];
    }

    public static function getText($inptype,$data_id,$result)
    {
        $str = '';
        $models = self::find()->where(['inptype_id'=>$inptype])->all();
        $i=0;
        $select = 0;
        foreach ($models as $key) {
            if($i>0&&$select==0){
                $str .= '<br>';
            }
            if($key->input_type=='number'){
                $str .= Html::input('number', 'pokaz['.$data_id.']', $result, ['class' => 'form-control ndataid'.$data_id, 'step' => '0.001', 'oninput'=>"mycheckvalue('n',".$data_id.")"]);
            }
            elseif($key->input_type=='text') {
                $str .= Html::input('text', 'pokaz['.$data_id.']', $result, ['class' => 'form-control tdataid'.$data_id, 'oninput'=>"mycheckvalue('t',".$data_id.")"]);
            }
            elseif($key->input_type=='select') {
                if($select==0){
                    $options = self::find()->where(['inptype_id'=>$inptype,'input_type'=>'select'])->all();
                    $arr = [];
                    foreach ($options as $option) {
                        $arr[$option->input_value] = $option->input_value;
                    }
                    $select++;
                }
                else{
                    continue;
                }
            }
            else{
                $str .= Html::input('number', 'pokaz['.$data_id.']', $result, ['class' => 'form-control ndataid'.$data_id, 'step' => '0.001', 'oninput'=>"mycheckvalue('n',".$data_id.")"]);
            }

            $i++;
        }

        if($select>0){
            if($str==''){
                $str .= Html::dropDownList('pokaz['.$data_id.']', $result, [''=>'Танланг...']+$arr,['class' => 'form-control sdataid'.$data_id, 'onchange'=>"mycheckvalue('s',".$data_id.")"]);
                $str .= '<br>';
            }
            else{
                $str .= '<br>';
                $str .= Html::dropDownList('pokaz['.$data_id.'a]', $result, [''=>'Танланг...']+$arr,['class' => 'form-control sdataid'.$data_id, 'onchange'=>"mycheckvalue('s',".$data_id.")"]);
            }
        }

        if($str==''){
            $str .= Html::input('number', 'pokaz['.$data_id.']', $result, ['class' => 'form-control ndataid'.$data_id, 'step' => '0.001', 'oninput'=>"mycheckvalue('n',".$data_id.")"]);
        }

        return $str;
    }
}
