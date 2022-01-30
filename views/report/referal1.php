<?php
use yii\helpers\Html;
use app\models\Filials;
use app\models\Referals;
$this->title = 'Рефераллар хисоботи';
?>

<div class="report-form card">
    <div class="card-body">
<?= Html::beginForm(['report/referal1prev'], 'post') ?>
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
        <label>Филиал</label>
        <?= Html::dropDownList('filial', '', Filials::getAll(), ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Реферал</label>
        <?= Html::dropDownList('refcode', '', Referals::getAll(), ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <label>Шифохона номи</label>
        <?= Html::input('text', 'shifoxona', '', ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Лавозим</label>
        <?= Html::input('text', 'lavozim', '', ['class' => 'form-control', 'prompt'=>'Барчаси']) ?>
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