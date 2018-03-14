<?php
return [
    'language' => 'zh-CN',
    'timeZone'=>'Asia/Shanghai',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'qiniu' => [    //七牛云
            'class' => 'chocoboxxf\Qiniu\Qiniu',
            //掌易七牛云
//            'accessKey' => 'k2f9setoLpz6mSao4zTMSKmkbVH9hnxFwkhnv5gq',  //1pWwW7ZmnYIpJLpEeB_ZXs2Tkfe5nTLlFoyxcvPa
//            'secretKey' => 'l_T1lApNbP8ZY154AE1w1i_wg6TFYt-1O7lRBvc7',  //n-Gx2HZoBt8VSzoZ-12I1euXzWmgjnp5O8g5L_5V
//            'domain' => 'om6d4y83l.bkt.clouddn.com',       //注意不要加http://头部
//            'bucket' => 'hwtbucket',

            //杭文投
            'accessKey' => '1pWwW7ZmnYIpJLpEeB_ZXs2Tkfe5nTLlFoyxcvPa',  //1pWwW7ZmnYIpJLpEeB_ZXs2Tkfe5nTLlFoyxcvPa
            'secretKey' => 'n-Gx2HZoBt8VSzoZ-12I1euXzWmgjnp5O8g5L_5V',  //n-Gx2HZoBt8VSzoZ-12I1euXzWmgjnp5O8g5L_5V
            'domain' => 'om4na3h1b.bkt.clouddn.com',       //注意不要加http://头部
            'bucket' => 'newhangwt',
            'secure' => false, // 是否使用HTTPS，默认为false
        ],
    ],
];
