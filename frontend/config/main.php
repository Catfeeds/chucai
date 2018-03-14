<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
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
        'feedback' => [

            'class' => 'backend\modules\feedback\Module',

        ],
        'aboutus' => [

            'class' => 'backend\modules\aboutus\model',

        ],
        'address' => [

            'class' => 'backend\modules\address\model',

        ],
        'family' => [

            'class' => 'backend\modules\family\model',

        ],
        'drugstore' => [

            'class' => 'backend\modules\drugstore\model',

        ],
        'banner' => [

            'class' => 'backend\modules\banner\model',

        ],
        'notice' => [    //公告管理

            'class' => 'backend\modules\notice\Module',

        ],
        'image' => [

            'class' => 'backend\modules\image\model',

        ],
        'health' => [

            'class' => 'backend\modules\health\model',

        ],
        'consult' => [

            'class' => 'backend\modules\consult\model',

        ],
        'institution' => [

            'class' => 'backend\modules\institution\model',

        ],
        'label' => [

            'class' => 'backend\modules\label\model',

        ],
        'package' => [

            'class' => 'backend\modules\package\model',

        ],
        'order' => [

            'class' => 'backend\modules\order\model',

        ],
        'personal' => [

            'class' => 'backend\modules\personal\model',

        ],
        'exam' => [

            'class' => 'backend\modules\exam\model',

        ],
        'appoint' => [

            'class' => 'backend\modules\appoint\model',

        ],

        'hospitalization' => [

            'class' => 'backend\modules\hospitalization\model',

        ],
        'sms' => [      //短信模块
            'class' => 'backend\modules\sms\Module',
        ],
        'coupon' => [

            'class' => 'backend\modules\coupon\model',

        ],
        'evaluate' => [

            'class' => 'backend\modules\evaluate\model',

        ],
        'wechat' => [

            'class' => 'frontend\modules\wechat\Module',

        ],

    ],
    'components' => [
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
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['order'],
                    'logFile' => '@app/runtime/logs/Mylog/requests.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
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
