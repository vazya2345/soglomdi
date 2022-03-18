<?php 
use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div class="cont">
<?= $content ?>
</div>
</body>
</html>
<?php $this->endPage() ?>
