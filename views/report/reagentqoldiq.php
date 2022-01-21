<?php
use yii\helpers\Html;
use app\models\Filials;
use app\models\Reagent;
$this->title = 'Юборилган пул хисоботи';
?>

<div class="report-form card">
    <div class="card-body">
<?= Html::beginForm(['report/reagentqoldiqprev'], 'post') ?>
<div class="row">
    <div class="form-group">
        <label>Реагент</label>
        <?= Html::dropDownList('reagent', '', Reagent::getAll(), ['class' => 'form-control', 'prompt'=>'Барчаси...']) ?>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label>Филиал</label>
        <?= Html::dropDownList('filial', '', Filials::getAll(), ['class' => 'form-control', 'prompt'=>'Барчаси...']) ?>
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