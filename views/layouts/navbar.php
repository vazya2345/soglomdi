<?php
use yii\helpers\Html;
use app\models\Users;
use app\models\ReagentNotifications;
use app\models\Reagent;
use app\models\Filials;
use app\models\Eslatma;
use app\models\Registration;
$name = Users::getMyname();
$lav = Users::getMyLav();


// Yii::$app->user->logout();die;
// var_dump(Users::getMyRole());die;
?>
<nav class="main-header navbar navbar-expand navbar-green navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <?= Html::a('Регистрациялар', ['/registration/index'], ['class' => 'nav-link']) ?>
        </li>
        <?php
            if(!Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1)){
        ?>
        <li class="nav-item dropdown">
            <!-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> -->
            <?= Html::a('Справочники', '#', ['class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-expanded'=>true]) ?>
            <ul class="dropdown-menu shadow">
                <li>
                    <?= Html::a('Тахлил', ['/s-analiz/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Гурух', ['/s-groups/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Кўрсаткич', ['/s-pokazatel/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Кўрсаткичлар чегараси', ['/pokaz-limits/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Лаб маълумот турлари', ['/inp-types/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Лаб маълумот справ', ['/inp-text/index'], ['class' => 'dropdown-item']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <!-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> -->
            <?= Html::a('Тизим', '#', ['class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-expanded'=>true]) ?>
            <ul class="dropdown-menu shadow">
                <li>
                    <?= Html::a('Филиаллар', ['/filials/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Касса', ['/filial-qoldiq/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Жўнатмалар', ['/fq-sends/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Фойдаланувчи', ['/users/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Роль', ['/role/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Рефераллар', ['/referals/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Реф жўнатма', ['/ref-sends/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Барча тўловлар', ['/payments/index'], ['class' => 'dropdown-item']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <!-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> -->
            <?= Html::a('Қўшимча', '#', ['class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-expanded'=>true]) ?>
            <ul class="dropdown-menu shadow">
                <li>
                    <?= Html::a('Мижозлар', ['/client/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Қўшимча маълумот', ['/reg-dopinfo/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Натижалар', ['/result/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Эслатмалар', ['/eslatma/index'], ['class' => 'dropdown-item']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <!-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> -->
            <?= Html::a('Реагент', '#', ['class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-expanded'=>true]) ?>
            <ul class="dropdown-menu shadow">
                <li>
                    <?= Html::a('Реагентлар', ['/reagent/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Реагент боғлиқлиги', ['/reagent-rel/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Реагент киритиш', ['/reagent-input/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Реагент юбориш', ['/reagent-send/index'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Реагент филиал', ['/reagent-filial/index'], ['class' => 'dropdown-item']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <?= Html::a('Хисоботлар', '#', ['class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-expanded'=>true]) ?>
            <ul class="dropdown-menu shadow">
                <li>
                    <?= Html::a('Қарздорлик', ['/report/qarzreportprev'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Докторлар1', ['/report/doktor1prev'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Лаборатор', ['/report/lab1prev'], ['class' => 'dropdown-item']) ?>
                </li>

                <li>
                    <?= Html::a('Юборилган пул', ['/report/moneysendprev'], ['class' => 'dropdown-item']) ?>
                </li>

                <li>
                    <?= Html::a('Реагент қолдиқлари', ['/report/reagentqoldiqprev'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Касса тушум чиқим', ['/report/kassatch1prev'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Харажатлар', ['/report/harajatlar1prev'], ['class' => 'dropdown-item']) ?>
                </li>
                <li>
                    <?= Html::a('Рефераллар', ['/report/referal1prev'], ['class' => 'dropdown-item']) ?>
                </li>
            </ul>
        </li>
        <?php        
            }
            elseif(!Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==6)){
        ?>
                <li class="nav-item">
                    <?= Html::a('Касса', ['/filial-qoldiq/index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Жўнатмалар', ['/fq-sends/index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Барча тўловлар', ['/payments/index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Реагент филиал', ['/reagent-filial/index'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <?= Html::a('Пул юбориш', ['/filial-qoldiq/sendmoney'], ['class' => 'nav-link']) ?>
                </li>
        <?php
            }
            elseif(!Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==9)){
        ?>
            <li class="nav-item dropdown">
                <?= Html::a('Справочники', '#', ['class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown', 'aria-expanded'=>true]) ?>
                <ul class="dropdown-menu shadow">
                    <li>
                        <?= Html::a('Қарздорлик', ['/report/qarzreportprev'], ['class' => 'dropdown-item']) ?>
                    </li>
                    <li>
                        <?= Html::a('Докторлар1', ['/report/doktor1prev'], ['class' => 'dropdown-item']) ?>
                    </li>
                    <li>
                        <?= Html::a('Реагент филиал', ['/reagent-filial/index'], ['class' => 'dropdown-item']) ?>
                    </li>
                    <li>
                        <?= Html::a('Рефераллар', ['/referals/index'], ['class' => 'dropdown-item']) ?>
                    </li>
                    <li>
                        <?= Html::a('Реф жўнатма', ['/ref-sends/index'], ['class' => 'dropdown-item']) ?>
                    </li>
                    <li>
                        <?= Html::a('Юборилган пул', ['/report/moneysendprev'], ['class' => 'dropdown-item']) ?>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <?= Html::a('Қарздорлар', ['registration/qarzdorlar'], ['class' => 'nav-link']) ?>
            </li>
        <?php
            }
        ?>
    </ul>



 <ul class="navbar-nav ml-auto">
<?php
if(!Yii::$app->user->isGuest&&(Yii::$app->user->getRole()==1||Yii::$app->user->getRole()==2||Yii::$app->user->getRole()==3||Yii::$app->user->getRole()==6||Yii::$app->user->getRole()==9)){
    echo '<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <p class="text-danger" style="display:inline-block;">
              <i class="fa fa-exclamation-triangle"></i>
            </p>
              Qarz: '.number_format(Registration::getQarzSum()).' so’m
            </a>
        </li>';
}
if(!Yii::$app->user->isGuest&&Yii::$app->user->getRole()!=8){
//REAGENT NOTIFICATIONS
$notifications = ReagentNotifications::find()->limit(5)->orderBy(['id'=>SORT_DESC])->all();
$count = count($notifications);
?>
    <!-- Right navbar links -->
   
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
              <i class="far fa-bell"></i>
              <span class="badge badge-danger navbar-badge"><?=$count?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
<?php
            foreach ($notifications as $key) {
                echo '
                    <a href="#" class="dropdown-item">
                        <div class="media">
                          <div class="media-body">
                            <p class="text-sm">'.Filials::getName($key->filial_id).'да</p>
                            <h3 class="dropdown-item-title">
                              <div class="notif_text">
                                <b>'.Reagent::getName($key->reagent_id).'</b> оз қолди.
                                <span class="float-right text-sm text-danger"><i class="fas fa-exclamation-circle"></i></span>
                              </div>
                            </h3>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>'.$key->create_date.'</p>
                          </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
              ';
            }
?>
              <a href="?r=reagent-notifications/index" class="dropdown-item dropdown-footer">Барча реагентлар эслатмалари</a>
            </div>
          </li>
        <!-- Notifications Dropdown Menu -->
<?php
    $eslatmalar = Eslatma::find()->orderBy(['id'=>SORT_DESC])->all();
    $esl_count = count($eslatmalar);
?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-warning navbar-badge"><?=$esl_count?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header"><?=$esl_count?> эслатма</span>
                <div class="dropdown-divider"></div>
<?php
foreach ($eslatmalar as $eslatma) {
    echo '
                <a href="#" class="dropdown-item">
                    <div class="eslatma_text">'.$eslatma->eslatma_text.'</div>
                </a>
                <div class="dropdown-divider"></div>
    ';
}
?>
            </div>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
<?php
}
    if(!Yii::$app->user->isGuest){
?>
    <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?=$name?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-success">
                    <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">

                    <p>
                        <?=$name?>
                        <small><?=$lav?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href="#">Руйхат</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Имконият</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Бонуслар</a>
                        </div>
                    </div>
                    <!-- /.row -->
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">Сахифам</a>
                    <?= Html::a('Тизимдан чикиш', ['site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                </li>
            </ul>
    </li>
<?php
    }
?>
        
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
        </li>
    </ul>
</nav>

<style type="text/css">
    .eslatma_text, .notif_text b{
        white-space: break-spaces;
    }
</style>