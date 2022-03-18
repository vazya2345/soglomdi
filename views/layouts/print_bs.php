<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
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
<body class="sidebar-collapse">
<?php $this->beginBody() ?>

<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <div class="d-flex justify-content-center w-100">
            <a href="https://t.me/Lormaslahat" target="_blank" class="text-green" style="font-size: 18px;">
                <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/telegram-3713743-3100712.png" width="15">
                Вопросы, ответы и новости        </a>
        </div>
        <ul class="navbar-nav ml-auto"></ul>
    </nav>



    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content_viewqr', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Nunito');
body{
    font-family: Nunito;
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 0;
}
.border-flag {
    border: 40px solid transparent;
    -o-border-image: url('./img/flag_border.png') 12% stretch;
    border-image: url('./img/flag_border.png') 12% stretch;
}
h4, .h4 {
    font-size: 1.35rem;
}
.h5, h5 {
    font-size: 1.25rem;
}
</style>