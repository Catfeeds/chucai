<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'ailisms' =>[
        'appkey'=>'24503582',
        'secretkey'=>'e041896399a2253c4dd5a6aec3c3343d',
        'signname' => "瑞梅移动医务室",
        'templatecode' => [
            'register'=>'SMS_72885031',     //注册模板
            'reset'=>'SMS_72550002',    //重置密码
            'change'=>'SMS_72585001',     //更换手机
        ]
    ],
    'WECHAT'=>[
        // 前面的appid什么的也得保留哦
        'debug'     => false,
        'app_id' => 'wx7dca056abe872fac', //你的APPID
        'secret'  => 'fefec767760b38252356502fa5080d73',     // AppSecret
        'token'   => 'palcommztnet86822511',          // Token
        // EncodingAESKey，安全模式下请一定要填写！！！
        // ...
        // payment
         'payment' => [
            'merchant_id'        => '1485755122',
            'key'                => '5ec0805cf38daee8fb3b2c0f05da423e',
            'cert_path'          => '/var/www/html/mywork/ruimei/libs/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
            'key_path'           => '/var/www/html/mywork/ruimei/libs/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
            'notify_url'         => 'http://ruimei.netmi.com.cn/wechat/pay-api/call-back',       // 你也可以在下单时单独设置来想覆盖它
            // 'device_info'     => '013467007045764',
            // 'sub_app_id'      => '',
            // 'sub_merchant_id' => '',
            // ...
        ],

    ],

    'smsConf.apiSendUrl' => "http://api.china95059.net:8080/sms/send",
    'smsConf.apiUsername' => "wgjt1",
    'smsConf.apiPassword' => "wgjt1001",

];
