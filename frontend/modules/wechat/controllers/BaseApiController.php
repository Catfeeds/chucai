<?php

namespace frontend\modules\wechat\controllers;

 
 
use EasyWeChat\Foundation\Application;
use yii\rest\Controller;


/**
 * Default controller for the `pay` module
 */
class BaseApiController extends Controller
{
    protected $Aps = [
//         'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
//         'onMenuShareQQ',
//         'onMenuShareWeibo',
//         'hideMenuItems',
//         'showMenuItems',
//         'hideAllNonBaseMenuItem',
//         'showAllNonBaseMenuItem',
//         'translateVoice',
//         'startRecord',
//         'stopRecord',
//         'onRecordEnd',
//         'playVoice',
//         'pauseVoice',
//         'stopVoice',
//         'uploadVoice',
//         'downloadVoice',
//         'chooseImage',
//         'previewImage',
//         'uploadImage',
//         'downloadImage',
//         'getNetworkType',
//         'openLocation',
//         'getLocation',
//         'hideOptionMenu',
//         'showOptionMenu',
//         'closeWindow',
//         'scanQRCode',
//         'chooseWXPay',
//         'openProductSpecificView',
//         'addCard',
//         'chooseCard',
//         'openCard'
    ];

    /**
     * 获取页面签名
     */
    public function actionWeixinSingal() {
        if (!\Yii::$app->request->isPost) {
    
            return response(10001,'invalid data',[]);
        }
        $url  = \Yii::$app->request->post('url',null);
        //         $url = 'http://bigscreen.palcomm.com.cn/page06.html';
        if (empty($url))
        {
            return response(20001,'invalid url',[]);
        }
        
        $app =  new Application(\Yii::$app->params['WECHAT']);
        $js = $app->js;
        $js->setUrl($url);
        $res_data = $js->config($this->Aps, true, false, false);
        return response(0,'success',$res_data);
    }
    
    /**
     * 获取openid
     */
    
    public function actionGetOpenid()
    {
        $cache = \Yii::$app->session;
        $shopdata = $cache['sass_user_wechat'];
        if (isset($shopdata))
        {
            $res_data = json_decode($shopdata,true);
            return response(0,'success',$res_data);
        }
        return response(2100,'无效openid');
    }
    
    
}
