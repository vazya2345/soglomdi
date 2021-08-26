<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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
<body class="sidebar-mini sidebar-collapse">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Асосий', 'url' => ['/site/index']],
            ['label' => 'Тизим хакида', 'url' => ['/site/about']],
            ['label' => 'Алока', 'url' => ['/site/contact']],
            [
                'label' => 'Справочник',
                'items' => [
                    ['label' => 'Анализ', 'url' => ['/s-analiz/index']],
                    ['label' => 'Группа', 'url' => ['/s-groups/index']],
                    ['label' => 'Курсатгич', 'url' => ['/s-pokazatel/index']],
                ],
            ],
            [
                'label' => 'Система',
                'items' => [
                    ['label' => 'Мижоз', 'url' => ['/client/index']],
                    ['label' => 'Курсатгичлар чегараси', 'url' => ['/pokaz-limits/index']],
                    ['label' => 'Кушимча маълумот', 'url' => ['/reg-dopinfo/index']],
                    ['label' => 'Ройхатдан утиш', 'url' => ['/registration/index']],
                    ['label' => 'Натижалар', 'url' => ['/result/index']],
                    ['label' => 'Роль', 'url' => ['/role/index']],
                    ['label' => 'Фойдаланувчи', 'url' => ['/user/index']],
                    ['label' => 'Анализлар кориниши', 'url' => ['/vid-analiz/index']],
                ] 
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Тизимга кириш', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Тизимдан чикиш (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
