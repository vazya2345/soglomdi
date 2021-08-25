<?php

use yii\helpers\Html;
use app\models\RegAnalizs;
use app\models\SAnaliz;
use app\models\Client;
/* @var $this yii\web\View */
/* @var $model app\models\Registration */

$this->title = 'Тахлилларни ўзгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Рўйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$analizs = RegAnalizs::find()->where(['reg_id'=>$model->id])->all();
// var_dump($analizs);
?>
<div class="registration-update card">
	<div class="card-body">
        <table class="table">
            <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th colspan="2"><?=Client::getClientNameByRegId($model->id)?></th>
                  <th>
                    <?=Html::a('Қўшиш', ['insert-analizs', 'reg_id'=>$model->id], ['class' => 'btn btn-success'])?>
                  </th>
                </tr>
            </thead>
            <tbody>
<?php
$i=1;
    foreach ($analizs as $reg_analiz) {
        $analiz = SAnaliz::findOne($reg_analiz->analiz_id);
        if($analiz){
            echo '
                        <tr>
                          <td>'.$i.'</td>
                          <td>'.$analiz->title.'</td>
                          <td>'.$analiz->price.'</td>
                          <td>'.Html::a('Ўчириш', ['reg-analizs/delete1', 'id' => $reg_analiz->id, 'regid' => $model->id], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Ушбу тахлилни ўчиришга ишончингиз комилми?',
                                                'method' => 'post',
                                            ],
                                        ]).'</td>
                        </tr>
            ';
            $i++;    
        }
        
    }
?>

                    </tbody>
                </table>
	</div>
</div>

                  
    
                  