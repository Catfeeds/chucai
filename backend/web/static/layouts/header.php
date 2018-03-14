<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">'.Yii::t('app', 'My Company logo').'</span><span class="logo-lg">' . Yii::t('app', 'My Company') . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>


        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">


                <!-- Messages: style can be found in dropdown.less-->
                
                <!-- Tasks: style can be found in dropdown.less -->
                
                <!-- User Account: style can be found in dropdown.less -->
                <!--<li class="user-body">
                <a href="#" data-toggle="fullscreen"><i class="fa fa-arrows-alt"></i></a>
                </li>-->
                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">欢迎你  <?=Yii::$app->user->getIdentity()->username; ?></span>
                    </a>




                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?=date("Y 年 m 月 d 日")?>
                                <small</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="user-body">
                             <div class="col-xs-4 text-center">
                                 <a href="#">Followers</a>
                             </div>
                             <div class="col-xs-4 text-center">
                                 <a href="#">Sales</a>
                             </div>
                             <div class="col-xs-4 text-center">
                                 <a href="#">Friends</a>
                             </div>
                         </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">张伟平</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    '退出登录',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>



                    </ul>
                <!-- User Account: style can be found in dropdown.less -->
                </li>
            </ul>
        </div>
    </nav>
</header>
