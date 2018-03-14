<?php

/* @var $this \yii\web\View */
/* @var $content string */

use wechat\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
    ];
    $menuItems[] = [
        'label' => '账户管理',
        'items' => [
            ['label' => '管理员列表', 'url' => ['/rbac/adminuser/index']],
            ['label' => '文件上传', 'url' => ['/site/upload']],
            '<li class="divider"></li>',

        ],
    ];
    $menuItems[] = [
        'label' => '会员管理',
        'items' => [
            ['label' => '会员列表', 'url' => ['#']],
            ['label' => '信息群发', 'url' => ['#']],
            '<li class="divider"></li>',

        ],
    ];
    $menuItems[] = [
        'label' => '商城管理',
        'items' => [
                ['label' => '商品管理', 'items' => [
                    ['label' => '分类管理', 'url' => ['/shop/category/index']],
                    ['label' => '商品管理', 'url' => ['/shop/item/index']],
                    '<li class="divider"></li>',
                ],
                ],
                ['label' => '交易管理', 'items' => [
                    ['label' => '订单管理', 'url' => ['/order/order/index']],
                    '<li class="divider"></li>',
                ],
                ],
        ],
    ];
    $menuItems[] = [
        'label' => '优惠券管理',
        'items' => [
            ['label' => '优惠券列表', 'url' => ['#']],
            '<li class="divider"></li>',

        ],
    ];
    $menuItems[] = [
        'label' => '活动管理',
        'items' => [
            ['label' => '活动列表', 'url' => ['#']],
            '<li class="divider"></li>',

        ],
    ];
    $menuItems[] = [
        'label' => '乐葫芦',
        'items' => [
            ['label' => '教师管理', 'url' => ['#']],
            ['label' => '课程管理', 'url' => ['#']],
            '<li class="divider"></li>',

        ],
    ];
    $menuItems[] = [
        'label' => '内容管理',
        'items' => [
            ['label' => 'banner管理', 'url' => ['#']],
            ['label' => '楼层管理', 'items' => [
                ['label' => '楼层编辑', 'url' => ['#']],
                ['label' => '首页楼层', 'url' => ['#']],
                ['label' => '商城楼层', 'url' => ['#']],
            ],
            ],
        ],
    ];
    $menuItems[] = [
        'label' => '数据中心',
        'items' => [
            ['label' => '无', 'url' => ['#']],
//            ['label' => '课程管理', 'url' => ['#']],
            '<li class="divider"></li>',

        ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
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
