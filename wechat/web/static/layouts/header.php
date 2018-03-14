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

                <li class="dropdown user user-menu">
                   
                <?= Html::a(
                    Yii::t('app', 'Logout').' (' . Yii::$app->user->identity->username . ')',
                    ['/site/logout'],
                    ['data-method' => 'post', 'class' => 'dropdown-toggle']
                ) ?>
                 
                    
                </li>

                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>
    </nav>
</header>
