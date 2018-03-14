<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'language' => 'zh-CN',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'agen' => [
            'class' => 'agencys\modules\agencys\Module',
        ],
        'rbac' => [
            'class' => 'backend\modules\rbac\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ],
        'gridviewKrajee' =>  [
            'class' => '\kartik\grid\Module',
            // your other grid module settings
        ],
        'base' => [     //基础类
        
            'class' => 'backend\modules\base\Module',
        
        ],
        'member' => [      //成员类
            
            'class' => 'frontend\modules\member\Module',
        
        ],
        'menu' => [
        
            'class' => 'backend\modules\menu\Module',

        ],
        'sale' => [

            'class' => 'backend\modules\sale\model',

        ],

        'adminuser' => [

            'class' => 'backend\modules\adminuser\Module',

        ],
        'bank' => [

            'class' => 'backend\modules\bank\model',

        ],
        'order' => [

            'class' => 'backend\modules\order\model',

        ],
        'good' => [

            'class' => 'backend\modules\good\model',

        ],
        'user' => [

            'class' => 'backend\modules\user\model',

        ],
        'article' => [

            'class' => 'backend\modules\article\model',

        ],

        'sms' => [

            'class' => 'backend\modules\sms\Module',

        ],
    ],
    'components' => [
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager', //用文件管理
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                //                'multipart/form-data' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
