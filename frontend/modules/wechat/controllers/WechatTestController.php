<?php

namespace frontend\modules\wechat\controllers;

 
 
use EasyWeChat\Foundation\Application;
use yii\web\Controller;
 


/**
 * Default controller for the `pay` module
 */
class WechatTestController extends Controller
{
    protected $Aps = [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
    ];
    public function actionIndex()
    {
        $app =  new Application(\Yii::$app->params['WECHAT']);
        $js = $app->js;
        return $this->render('index', [
            'js' => $js,
        ]);
    }

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
        $res_data = $js->config($this->Aps, true, false, true);
        return response(0,'success',$res_data);
    }
    
    
}
