<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Filials;
use app\models\Role;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Руйхат', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="role-view card">
    <div class="card-body">
    <p>
        <?= Html::a('Узгартириш', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Учириш', ['delete', 'id' => $model->id], [
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
            'name',
            'add1'=>[
                'attribute'=>'add1',
                'value'=>function ($model) {
                        return Filials::getName($model->add1);                    
                }
            ],
            'lavozim',
            'role_id'=>[
                'attribute'=>'role_id',
                'value'=>function ($model) {
                        return Role::getName($model->role_id);                    
                }
            ],
            'active',
            'login',
            'password',
            'mobile',
            'info:ntext',
            'img',
            'other',
            
        ],
    ]) ?>
    </div>
</div>
