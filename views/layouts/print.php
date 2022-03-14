<?php 
use yii\helpers\Html;
$this->beginPage();

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
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

<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Nunito');
    body{
        font-family: "Times New Roman";
        font-size: 11px;
    }
    .cont{
        width: 1000px;
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
        font-size: 30px;
        font-family: INITIAL;
        font-weight: bold;
        text-align: center;
        position: relative;
        top: 20px;
    }
</style>
