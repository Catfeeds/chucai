<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'language' => 'zh-CN',
    'id' => 'app-wechat',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'wechat\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'coupon' => [       //优惠券
            'class' => 'wechat\modules\coupon\Module',
        ],
        'coterie' => [      //圈子信息管理
        
            'class' => 'lehulu\modules\coterie\Module',
        
        ],
        'hulubase' => [     //基础信息管理
        
            'class' => 'lehulu\modules\hulubase\Module',
        
        ],
        'teacher' => [  //乐葫芦  教师管理
        
            'class' => 'lehulu\modules\teacher\Module',
        
        ],
        'courses' => [      //乐葫芦 课程相关
        
            'class' => 'lehulu\modules\courses\Module',
        
        ],
        'rbac' => [
            'class' => 'wechat\modules\rbac\Module',
        ],
        'info' => [     //新闻消息类
        
            'class' => 'wechat\modules\info\Module',
        ],
        'adv' => [      //广告类
            
            'class' => 'wechat\modules\adv\Module',
            
        ],
        'floor' => [    //楼层类
            'class' => 'wechat\modules\floor\Module',
        ],
        'base' => [     //基础类
        
            'class' => 'wechat\modules\base\Module',
        
        ],
        'member' => [      //成员类
            
            'class' => 'frontend\modules\member\Module',
        
        ],
        'order' => [    //商品订单类
        
            'class' => 'merchant\modules\order\Module',
        
        ],
        'shop' => [     //商品信息类
            'class' => 'merchant\modules\shop\Module',
        ],
        'shopbase' => [     //商品基本信息配置类
        
            'class' => 'merchant\modules\base\Module',
        
        ],
        'act' => [  //活动类
            'class' => 'wechat\modules\act\Module',
        ],
        'data' => [     //数据报表类
        
            'class' => 'wechat\modules\data\Module',
        
        ],
        'menu' => [
        
            'class' => 'wechat\modules\menu\Module',
        
        ],
        'notice' => [
            'class' => 'wechat\modules\notice\Module',
        ],
    ],
    'components' => [
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager', //用文件管理
        ],
        'request' => [
            'csrfParam' => '_csrf-wechat',
        ],
        'user' => [
            'identityClass' => 'wechat\modules\rbac\models\Adminuser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-wechat', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the wechat
            'name' => 'advanced-wechat',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@webroot/static',
                ],
            ],
        ],
        
    ],
    'params' => $params,
];
