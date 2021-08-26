<?php
use app\models\Users;
$name = Users::getMyname();
?>

<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="img/logo_barg.png" alt="MTD" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">S/D</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [



                    //ADMIN
                    ['label' => 'Регистрациялар', 'url' => ['/registration/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Мижозлар', 'url' => ['/client/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    
                    ['label' => 'Тахлил', 'url' => ['/s-analiz/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Гурух', 'url' => ['/s-groups/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Кўрсаткич', 'url' => ['/s-pokazatel/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],

                    ['label' => 'Қўшимча маълумот', 'url' => ['/reg-dopinfo/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Натижалар', 'url' => ['/result/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Анализлар турлари', 'url' => ['/vid-analiz/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Кўрсаткичлар чегараси', 'url' => ['/pokaz-limits/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Лаб маълумот турлари', 'url' => ['/inp-types/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Лаб маълумот справ', 'url' => ['/inp-text/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Роль', 'url' => ['/role/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Фойдаланувчи', 'url' => ['/users/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    
                    
                    ///REG
                    ['label' => 'Регистрациялар', 'url' => ['/registration/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==2)],

                    //KASSA
                    ['label' => 'Регистрациялар', 'url' => ['/registration/indexkassa'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==3)],
                    ['label' => 'Касса', 'url' => ['/filial-qoldiq/indexkassa'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==3)],  
                    ['label' => 'Лаборант', 'url' => ['/registration/indexlab'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==3)],
                    ['label' => 'Реагент қолдиқлари', 'url' => ['/reagent-filial/indexkassa'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==3)],
                    ['label' => 'Тахлил қўшиш/айриш', 'url' => ['/registration/indexupdate'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==3)],
                    ['label' => 'Хисобот', 'url' => ['/report/kassa1prev'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==3)],
                    //LAB
                    ['label' => 'Регистрациялар', 'url' => ['/registration/indexlab'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==4)],


                    ['label' => 'Тизимга кириш', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],




                    ['label' => 'Рефераллар', 'url' => ['/referals/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==2||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==4)],


                    ///REFERAL
                    ['label' => 'Регистрациялар', 'url' => ['/registration/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==8)],
                    ['label' => 'Жўнатмалар', 'url' => ['/ref-sends/indexref'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==8)],


                    
                    ['label' => 'Дастур хакида', 'header' => true],
                    ['label' => 'Асосий маълумот', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Карши курсатмалар', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Алока', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>