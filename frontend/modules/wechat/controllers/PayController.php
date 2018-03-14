<?php

namespace frontend\modules\wechat\controllers;

 
use yii\web\Controller;
use EasyWeChat\Foundation\Application;

use agencys\modules\agencysuser\models\AgencysUser;
use backend\modules\base\models\Content;



/**
 * Default controller for the `pay` module
 */
class PayController extends Controller
{
    /**
     * 页面获取授权，获取用户openid
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $cache = \Yii::$app->session;
         $shopdata = $cache['sass_user_wechat'];
         $getMsg = \Yii::$app->request->get();
        if (isset($shopdata))
        {
            $wechatdata = json_decode($shopdata,true);
            if (!empty($wechatdata['openid']) && !empty($wechatdata['agency_id']))
            {
                $this->PayLog('缓存数据：'.json_encode($shopdata));
                $getdata = $wechatdata;
            }   
        }
        if (empty($getdata['login_type']))
        {
            $getdata['login_type'] = 1;
        }
        if (!empty($getMsg['sass_action']))
        {
            $getdata['sass_action'] = $getMsg['sass_action'];
        }
        if (!empty($getMsg['p_openid']))
        {
            $getdata['p_openid'] = $getMsg['p_openid'];
        }
        if (empty($getdata['p_openid']))
        {
            $getdata['p_openid'] = null;
        }
        
        if (!empty($getMsg['item_id']))
        {
            $getdata['item_id'] = $getMsg['item_id'];
        }
        if (empty($getdata['item_id']))
        {
            $getdata['item_id'] = null;
        }
        
        if (!empty($getMsg['pid']))
        {
            $getdata['pid'] = $getMsg['pid'];
        }
        
        if (empty($getdata['pid']))
        {
            $getdata['pid'] = null;
        }
        
        if (empty($getdata['p_openid']))
        {
            $getdata['p_openid'] = null;
        }
        
        
        $cache = \Yii::$app->session;
//         $cache->set('sass_user_wechat', json_encode($getdata));
        
        if (empty($getdata['openid']))
        {
            $getdata['openid'] = null;
        }
        $casedata = [
            'openid' => $getdata['openid'],
        ];
        $cache->set('sass_user_wechat', json_encode($casedata));
        
        if (!empty($getdata['openid']))
        {
//             echo "1";
//             var_dump($getdata);die;
            if (($getdata['sass_action'] == 'login') && ($getdata['login_type'] == 2))
            {
                
            }
            else 
            {
                $this->layout = false;
                
                if (!empty(AgencysUser::find()->where(['openid'=>$getdata['openid']])->asArray()->one()))
                {
                    $getdata['login_type'] = 2;
                
                }
                
                $this->layout = false;
                //             var_dump($getdata);die;
                $this->PayLog('最新缓存数据：'.$shopdata = $cache['sass_user_wechat']);
                return $this->renderPartial('@webroot/bx_mobile/src/index.html',[
                    'wechat_data' => $getdata,
                ]);
            }
           
        }
        
        
//         return $this->redirect(['test-back']);
        
        
        $app =  new Application(\Yii::$app->params['WECHAT']);
        $oauth = $app->oauth;
        $getdata = \Yii::$app->request->get();
//         var_dump($getdata);die;
//         $cache = \Yii::$app->cache;
        if (empty($getdata))
        {
            $getdata = [
                'login_type'=>1,    //1: 未注册 ， 请先注册    2： 已注册 ， 直接登录
                'openid'=>'',
                'agency_id'=>2,
                'sass_action' => 'login',
            ];
        }
        $getdata['login_type'] = 1;
        $cache->set('sass_user_wechat', json_encode($getdata));
         
        return $oauth->redirect()->send();
    }
    
    /**
     * 测试返回
     */
    public function actionTestBack()
    {
        $cache = \Yii::$app->session;
        $getdata = array();
        $shopdata = $cache['sass_user_wechat'];
        $getdata = json_decode($shopdata,true);
        $getdata['openid'] = '1495162401';
        $cache->set('sass_user_wechat', json_encode($getdata));
//         var_dump($getdata);die;
        return $this->redirect(['/bx_mobile/src/index'],$getdata);
    }
    
    
    /**
     * 微信支付测试、创建订单、这里需要换成api 返回页面需要参数即可
     */

    /**
     * 生成签名与订单
     */
    public function actionMakePay()
    {
    
        $getdata = \Yii::$app->request->post();
         $getdata = [
            'order_id'=>15,      //订单主键
            'price'=>61,      //金额
            'openid'=>'od0K-1WMbAPGcrlAQri44Ip6XoZ0',   //支付者openid
        ]; 
         
        if (empty($getdata['order_id']) || empty($getdata['price']) || empty($getdata['openid']))
        {
            return response(10001,'无效数据');
        }
        /**
         * 获取订单数据
         */
        $order = \rpitem\modules\order\models\Order::find()->joinWith(['item.i','plan'])->where(['order.id'=>$getdata['order_id'],'order.status'=>3])->asArray()->one();
        if (empty($order['id']))
        {
            return response(20002,'无效订单');
        }
        if ($order['status'] != 3)
        {
            return response(20022,'非法操作');
        }
        if ($order['sum_price'] != $getdata['price'])
        {
            return response(20003,'金额错误');
        }
        /**
         * 更新订单号
         * @var unknown
         */
        $orderModel = \rpitem\modules\order\models\Order::findOne($order['id']);
        $orderModel->order_code = build_order_no();
        $orderModel->save();
        $order['order_code'] = $orderModel->order_code;
    
        $res_data['item'] = $order['item'];
        $res_data['item']['sum_price'] = $order['sum_price'];
        //         return response(0,'',$order);
        /**
         * 生成支付订单
         * @var unknown
        */
        $app =  new Application(\Yii::$app->params['WECHAT']);
    
        $payment = $app->payment;
        /**
         * 产品数据 数据库读取
         * @var unknown
         */
        $attributes = [
            'trade_type' => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'  => $order['item']['title'].' '.$order['plan']['name'],  //商品描述
            'detail' => $order['item']['title'].' '.$order['plan']['name'],     //商品详情
            //             'attach',    //附加数据
            'out_trade_no' => $order['order_code'],   //商户订单号
            //             'fee_type',  //标价币种
            'total_fee'=> 1, // 标价金额 单位：分,
            //             'spbill_create_ip',      //终端ip
            //             'time_start',    //交易起始时间
            //             'time_expire',   //交易结束时间
            //             'goods_tag',     //商品标记
            //             'notify_url',    //回调地址
            //             'trade_type',    //交易类型
            //             'product_id',    //商品主键
            //             'limit_pay',     //指定支付方式
            'openid'=> $getdata['openid'],
            //             'sub_openid',
            //             'auth_code',
        ];
        $order = new \EasyWeChat\Payment\Order($attributes);
        //统一下单 ，完成订单创建
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            $jsApiConfig = $payment->configForPayment($prepayId);
            $token =  $app->access_token->getToken();
            $configForPickAddress = $payment->configForShareAddress($token);
    
            $res_data['jsApiConfig'] = $jsApiConfig;
            $res_data['editAddress'] = $jsApiConfig;
             return $this->render('make-pay',[
                    'jsApiConfig' => $jsApiConfig,
                    'editAddress' => $jsApiConfig,
                ]);
        }
        return response(20010,'系统繁忙，请等待几分钟后重试');
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
//         var_dump($getdata);die;
//         $this->layout = false;
        if (($getdata['sass_action'] == 'login'))
        {
           
//             echo "3";
//             var_dump($getdata);die;
//             if (!empty(AgencysUser::find()->where(['openid'=>$getdata['openid']])->asArray()->one()))
//             {
                $getdata['login_type'] = null;
            
//             }
            $cache->set('sass_user_wechat', json_encode($getdata));
//             $this->layout = false;
           /*  return $this->renderPartial('@webroot/bx_mobile/src/index.html',[
                'wechat_data'=>$getdata
            ]); */
            $url= '?';
            foreach ($getdata as $key=>$v)
            {
                $url .= $key.'='.$v.'&';
            }
            return $this->redirect('/bx_mobile/src/layout/mobile/index'.$url);
        }
        
        $cache->set('sass_user_wechat', json_encode($getdata));
//         var_dump($getdata);die;
        $url= '?';
        foreach ($getdata as $key=>$v)
        {
            $url .= $key.'='.$v.'&';
        }
        return $this->redirect('/bx_mobile/src/layout/mobile/index'.$url);
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
        $model->save();
    
        return true;
    }
    
}
