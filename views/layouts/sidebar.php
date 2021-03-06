<?php
use app\models\Users;
$name = Users::getMyname();
?>

<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="../../web/img/logo_barg.png" alt="MTD" class="brand-image img-circle elevation-3"
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

                    [
                        'label' => 'Справочник',
                        'url' => '#',
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1),
                        'items' => [
                            ['label' => 'Тахлил', 'url' => ['/s-analiz/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Гурух', 'url' => ['/s-groups/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Кўрсаткич', 'url' => ['/s-pokazatel/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Қўшимча маълумот', 'url' => ['/reg-dopinfo/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Натижалар', 'url' => ['/result/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Анализлар турлари', 'url' => ['/vid-analiz/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Кўрсаткичлар чегараси', 'url' => ['/pokaz-limits/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Лаб маълумот турлари', 'url' => ['/inp-types/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Лаб маълумот справ', 'url' => ['/inp-text/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                                ],
                    ],
                    [
                        'label' => 'Юзер',
                        'url' => '#',
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1),
                        'items' => [
                            ['label' => 'Роль', 'url' => ['/role/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Фойдаланувчи', 'url' => ['/users/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],

                            ['label' => 'Реф юзер', 'url' => ['/users/indexref'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Рефераллар', 'url' => ['/referals/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&Yii::$app->user->getRole()==1],
                        ],
                    ],
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


                    ['label' => 'Тизимга кириш', 'url' => ['/site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],




                    ['label' => 'Рефераллар', 'url' => ['/referals/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==2||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==4)],


                    ///REFERAL
                    ['label' => 'Регистрациялар', 'url' => ['/registration/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==8)],
                    ['label' => 'Жўнатмалар', 'url' => ['/ref-sends/indexref'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==8)],

                    ['label' => 'СМС шаблон', 'url' => ['/sms-templates/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],

                    [
                        'label' => 'Чиқимлар',
                        'url' => '#',
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1),
                        'items' => [
                            ['label' => 'Чиқим турлари', 'url' => ['/s-rasxod-types/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                            ['label' => 'Чиқимлар', 'url' => ['/rasxod/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                        ],
                    ],

                    ['label' => 'Регистрациялар', 'url' => ['/registration/indexlab'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==5)],
                    ['label' => 'Лаборатор хисобот', 'url' => ['/report/lab1prev'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==5)],


                    /// ZAVKASSA

                    ['label' => 'Касса', 'url' => ['/filial-qoldiq/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6)],
                    ['label' => 'Жўнатмалар', 'url' => ['/fq-sends/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6)],
                    ['label' => 'Барча тўловлар', 'url' => ['/payments/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6)],
                    ['label' => 'Реагент филиал', 'url' => ['/reagent-filial/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6)],
                    

                    [
                        'label' => 'Пул юбориш',
                        'url' => ['#'],
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9),
                        'items' => [
                            [
                                'label' => 'Юборилган пул',
                                'url' => ['/money-send/index'],
                                'icon' => 'circle',
                                'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9),
                            ],
                            [
                                'label' => 'Пул юбориш',
                                'url' => ['/filial-qoldiq/sendmoney'],
                                'icon' => 'circle',
                                'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9),
                            ],
                            [
                                'label' => 'Чиқимлар',
                                'url' => ['/rasxod/index'],
                                'icon' => 'circle',
                                'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==9),
                            ],
                            [
                                'label' => 'Чиқим қилиш',
                                'url' => ['/rasxod/create'],
                                'icon' => 'circle',
                                'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==9),
                            ],
                        ],
                    ],

                    [
                        'label' => 'Ойлик хисоблаш',
                        'url' => '#',
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9),
                        'items' => [
                            ['label' => 'Ходимлар', 'url' => ['/oylik-hodimlar/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9)],
                            ['label' => 'Ушланмалар', 'url' => ['/oylik-uderj/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9)],
                            ['label' => 'Шаклланиши', 'url' => ['/oylik-shakl/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9)],
                            ['label' => 'Давр', 'url' => ['/oylik-periods/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9)],
                            ['label' => 'Ушланма турлари', 'url' => ['/oylik-uderj-types/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==9)],
                        ]
                    ],


                    [
                        'label' => 'Дори',
                        'url' => '#',
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10),
                        'items' => [
                            ['label' => 'Дорилар', 'url' => ['/dori/dori-list/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Дори махали', 'url' => ['/dori/dori-mahali/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Дори давомийлиги', 'url' => ['/dori/dori-davomiyligi/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Дори қайвақтда', 'url' => ['/dori/dori-qayvaqtda/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Дори шакллари', 'url' => ['/dori/dori-shakli/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Дори қабул қилиш', 'url' => ['/dori/dori-qabul/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                        ]
                    ],

                    [
                        'label' => 'Консультация',
                        'url' => '#',
                        'icon' => 'dot-circle',
                        'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10),
                        'items' => [
                            ['label' => 'Ташхислар', 'url' => ['/consultation/consultation-tashhis-list/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Операциялар', 'url' => ['/consultation/consultation-operation-list/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Анестезиялар', 'url' => ['/consultation/consultation-annestezy-list/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                            ['label' => 'Консультациялар', 'url' => ['/consultation/consultation-main/index'], 'icon' => 'circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==10)],
                        ]
                    ],

                    


                    /// END ZAVKASSA
                    ['label' => 'Касса', 'url' => ['/filial-qoldiq/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==9)],

                    ['label' => 'Тизим маълумотлари', 'url' => ['/system-variables/index'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)],
                    ['label' => 'Пароль ўзгартириш', 'url' => ['/users/updatepas'], 'icon' => 'dot-circle', 'visible' => !Yii::$app->user->isGuest],

                    
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>