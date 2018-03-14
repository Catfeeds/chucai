<?php

namespace frontend\modules\wechat\controllers;

 
use yii\web\Controller;
use EasyWeChat\Foundation\Application;

use agencys\modules\agencysuser\models\AgencysUser;
use backend\modules\base\models\Content;



/**
 * Default controller for the `pay` module
 */
class IndexController extends Controller
{
    /**
     * 页面获取授权，获取用户openid
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
//         var_dump($_SERVER);
//         die;
        $cache = \Yii::$app->session;
         $shopdata = $cache['sass_user_wechat'];
        if (isset($shopdata))
        {
            $wechatdata = json_decode($shopdata,true);
            if (!empty($wechatdata['openid']))
            {
                $this->PayLog('缓存数据：'.json_encode($shopdata));
                $getdata = $wechatdata;
            }   
        }
        if (!empty($getdata['openid']))
        {
 
                $this->layout = false;
                $this->PayLog('最新缓存数据：'.$shopdata = $cache['sass_user_wechat']);
//                var_dump($getdata);die;
                return $this->renderPartial('@webroot/bx_mobile/src/openid.html',[
                    'wechat_data' => $getdata,
                ]);
        }
        $app =  new Application(\Yii::$app->params['WECHAT']);
        $oauth = $app->oauth;
        $getdata = \Yii::$app->request->get();
        if (empty($getdata))
        {
            $getdata = [
                'openid'=>'',
                'agency_id'=>2,
            ];
        }
        $cache->set('sass_user_wechat', json_encode($getdata));
         
        return $oauth->redirect()->send();
    }
    
    
    /**
     * 微信支付测试、创建订单、这里需要换成api 返回页面需要参数即可
     */
    public function actionGetData()
    {
        $cache = \Yii::$app->session;
        $shopdata = $cache['sass_user_wechat'];
        var_dump($shopdata);die;
    }
   
    
    //日志记录
    /**
     * 用户授权返回openid
     */
    public function actionOauthCallBack()
    {
//         $this->layout = false;
//         return $this->redirect(['/bx_mobile/src/index']);
        
         
        $cache = \Yii::$app->session;
        
        $getdata = array();
        $shopdata = $cache['sass_user_wechat'];
        //         $userData =  $user->getId();
        
  
        $getdata = json_decode($shopdata,true);
    
         
        $app =  new Application(\Yii::$app->params['WECHAT']);
        $oauth = $app->oauth;
        $user = $oauth->user();
        $getdata['openid'] = $user->getId();
        $cache->set('sass_user_wechat', json_encode($getdata));
        
        $url= '?';
        foreach ($getdata as $key=>$v)
        {
            $url .= $key.'='.$v.'&';
        }
//         var_dump($getdata);die;
        return $this->redirect('index'.$url);
    }
    
    //日志记录
    protected  function PayLog($content='')
    {
     
        $model =   new Content();
        $addMsg = [
            'type'=>'3',
            'agency_id'=>20000,
            'content'=>$content,
        ];
        $model->setAttributes($addMsg);
//         $model->save();
    
        return true;
    }
    
}
