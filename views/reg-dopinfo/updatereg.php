<?php

use yii\helpers\Html;
use app\models\PokazLimits;

/* @var $this yii\web\View */
/* @var $model app\models\RegDopinfo */

$this->title = 'Танланган маълумотларни ўзгартириш';
$this->params['breadcrumbs'][] = ['label' => 'Ортга', 'url' => Yii::$app->request->referrer];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reg-dopinfo-view card">
    <div class="card-body">
        <?= Html::beginForm() ?>
        <div class="row">
            
<?php
        foreach ($models as $key) {
            echo PokazLimits::getOneInfo($key->indikator_id, $key->value, $key->reg_id);
        }
?>
            
        </div>
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
