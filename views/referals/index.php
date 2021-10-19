<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Filials;
use app\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ReferalsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рефераллар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referals-index card">
    <div class="card-body">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'filial'=>[
                'attribute'=>'filial',
                'filter'=>Filials::getAll(),
                'value' => function ($data) {
                    return Filials::getName($data->filial);
                }
            ],
            'refnum',
            // 'id',
            'fio',
            // 
            // 'user_id',
            'desc',
            //'info:ntext',
            //'add1',
            'phone',
            'qoldiq_summa',
            [
                'header'=>'Хисоб',
                'format'=>'raw',
                'value' => function ($data) {
                    if($data->filial==Users::getMyFil()){
                        return Html::a('Хисоб', ['hisob', 'id'=>$data->id])
                        .'<br>'.
                            Html::a('Нақд', ['send', 'id'=>$data->id, 'type'=>1],[
                                'data' => [
                                    'confirm' => 'Сиз '.$data->qoldiq_summa.' сўм НАҚД пул юбормоқчисиз. Ишончингиз комилми?',
                                ]

                            ])
                        .'<br>'.
                            Html::a('Пластик', ['send', 'id'=>$data->id, 'type'=>2],[
                                'data' => [
                                    'confirm' => 'Сиз '.$data->qoldiq_summa.' сўм ПЛАСТИК орқали юбормоқчисиз. Ишончингиз комилми?',
                                ]

                            ]);    
                    }
                    else{
                        return '';
                    }
                }
            ],

            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'template' => '{view}',
            // ],
        ],
    ]); ?>

    </div>
</div>
