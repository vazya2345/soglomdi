<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\consultation\models\ConsultationDoriRecept */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="consultation-dori-recept-view card">
    <div class="card-body">
    <p>
        <?= Html::a('Ўзгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Ўчириш', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ишончингиз комилми?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'reg_id',
            'dori_title',
            'dori_doza',
            'dori_shakli',
            'dori_mahali',
            'dori_davomiyligi',
            'dori_qabul',
            'dori_qayvaqtda',
            'create_date',
            'create_userid',
        ],
    ]) ?>
    </div>
</div>
