<?php 
use yii\helpers\Html;
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
</head>
<body>
<div class="cont">

    <?= $content ?>


<footer class="footer">
<br><br>
</footer>
</div>
</body>
</html>
<?php $this->endPage() ?>

<style type="text/css">
    body{
        font-family: "Arial";
        font-size: 16px;
    }
    .cont{
        width: 320px;
        margin: 0 auto;
    }
    .tb-header{
        width: 100%;
    }
    .logo{
        position: relative;
        top: 0px;
    }
    .main_title{
        font-size: 28px;
        font-family: INITIAL;
        font-weight: bold;
        text-align: center;
        position: relative;
    }
</style>