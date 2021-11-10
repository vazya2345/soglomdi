<?php
use yii\helpers\Html;
use app\models\Users;
$this->title = 'Юборилган пул хисоботи';
?>

<div class="report-form card">
    <div class="card-body">
<?= Html::beginForm(['report/moneysendprev'], 'post') ?>
<div class="row">
    <div class="form-group">
    <label>Бошлағич сана</label>
    <?= Html::input('date', 'date1', '', ['class' => 'form-control']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Якуний сана</label>
        <?= Html::input('date', 'date2', '', ['class' => 'form-control']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Ўтказма тури</label>
        <?= Html::dropDownList('sendtype', '', [1=>'Нақд',2=>'Пластик'], ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Юборган ходим</label>
        <?= Html::dropDownList('sender', '', Users::getAll(), ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Қабул қилган ходим</label>
        <?= Html::dropDownList('receiver', '', Users::getAll(), ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <?= Html::submitButton('Хисобот олиш', ['class' => 'form-control submit btn btn-primary']) ?>
    </div>
</div>
<?= Html::endForm() ?>
    </div>
</div>