<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'language' => 'zh-CN',
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'agen' => [
            'class' => 'agencys\modules\agencys\Module',
        ],
        'rbac' => [
            'class' => 'backend\modules\rbac\Module',
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
        'user' => [     //平台用户类

            'class' => 'backend\modules\user\Module',

        ],
        'ruiuser' => [

            'class' => 'backend\modules\ruiuser\model',

        ],
        'company' => [

            'class' => 'backend\modules\company\Module',

        ],
        'news' => [

            'class' => 'backend\modules\news\model',

        ],

    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', //用文件管理
        ],
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
//                'multipart/form-data' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'backend\modules\rbac\models\Adminuser',
            'enableAutoLogin' => true,
            'enableSession' => false,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-api',
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
    ],
    'params' => $params,
];
