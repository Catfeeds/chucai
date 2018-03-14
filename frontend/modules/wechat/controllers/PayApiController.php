<?php
/**
 * User: zwp
 * Remark: 微信支付回调函数
 * Date: 2017-07-03 22:39:53
 * Copyright (c) 2016-2017 *********公司技术开发部
 */


namespace frontend\modules\wechat\controllers;


use backend\modules\order\models\IntelData;
use backend\modules\order\models\OrderBill;
use backend\modules\order\models\OrderLog;
use Yii;
use yii\web\HttpException;
use backend\modules\coupon\models\CouponUser;
use backend\modules\ruiuser\models\RuiUser;
use backend\modules\ruiuser\models\Vips;
use yii\rest\Controller;
use backend\modules\base\models\Content;
use EasyWeChat\Foundation\Application;
use backend\modules\order\models\Order;
use yii\base\Object;
use backend\modules\notice\models\Notice;
use common\components\BaseApiController;

/**
 * Default controller for the `pay` module
 */
class PayApiController extends Controller
{
  
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        var_dump(\Yii::$app->params['WECHAT']);
        die;
    }

    //回调函数
    public function actionCallBack()
    {
//        $this->PayLog('进入回调1');
//        $notify->out_trade_no
        /*$getdata=[
            'order_number'=>'2017070310154985',
        ];*/
        $app =  new Application(\Yii::$app->params['WECHAT']);
        $response = $app->payment->handleNotify(function($notify, $successful){
//            $this->PayLog(json_encode($notify));

            // 成功失败
            if (!$successful) {
                Yii::info('业务异常(返回失败)','order');
                return false;
            }

            Yii::info('业务处理开始','order');
//                $this->PayLog(json_encode($notify));
            //支付成功， 做好订单记录
            //查询订单
            $flag = false;  //是否是第二次付款
            $model = Order::find()->where(['order_number'=>$notify->out_trade_no])->one();
            if (!$model) {
                $model = Order::find()->where(['second_number'=>$notify->out_trade_no])->one();
                if (!$model) {
                    Yii::info('无效订单号','order');
                    Yii::info(['order_number'=>$notify->out_trade_no],'order');
                    return false;
                }
                $flag = true;
            }
            //待付款状态 type,1:待付款(第一次) 2:付款完成  3:已完成 9:待付款（第二次） 8:付款完成（第二次）
            if ($model->type == 1) {
//                        $this->PayLog(json_encode('1'.$model));
                if ($model->order_type == 2) {
                    $model->type = 10;
                    $model->save();
                    $log = new OrderLog();
                    $add = [
                        'order_id' => $model->id,
                        'order_number' => $model->order_number,
                        'uid' =>$model->userid,
                        'status' => $model->type,
                        'label' => '订单交易成功。',
                    ];
                    $log->setAttributes($add);
                    $log->save();
                } else {
                    $model->type = 2;
                    $model->save();
                    /**
                     * 1、给用户新增积分
                     */
                    $score = round($model['sum_price'] / 10);

                    $usermodel = RuiUser::findOne($model['userid']);

                    $usermodel->score += $score;

                    /**
                     * 2、更新用户等级
                     */
                    $vipmodel = Vips::find()->where(['>=', 'score', $usermodel->score])->orderBy('sort asc')->one();
                    $usermodel->vip = $vipmodel['sort'];

                    $usermodel->save();

                    /**
                     * 3、生成流水账单
                     */
                    $bill = new OrderBill();
                    $addmessage= [
                        'order_number'=>$model['order_number'],
                        'price'=>$model['sum_price'],
                        'type'=>1,
                    ];
                    $bill->setAttributes($addmessage);
                    $bill->save();
                    /**
                     * 4、更新资金总额
                     */
                    $intelModel =  IntelData::findOne(1);
                    $intelModel->gold += $model['sum_price'];
                    $intelModel->gold_history += $model['sum_price'];
                    $intelModel->save();
                    $log = new OrderLog();
                    $add = [
                        'order_id' => $model->id,
                        'order_number' => $model->order_number,
                        'uid' =>$model->userid,
                        'status' => $model->type,
                        'label' => '订单交易成功。',
                    ];
                    $log->setAttributes($add);
                    $log->save();
                    Yii::info('业务处理结束（待付款=》交易成功）','order');
                    return true;

                }
                if (!$model->save()) {
                    return false;
                }

            }

            if ($model->type == 9 && $flag) {
                $model->type = 8;
                $model->save();
//                        $this->PayLog(json_encode('5'.$model));
                /**
                 * 1、给用户新增积分
                 */
                $score = round($model['sum_price'] / 10);

                $usermodel = RuiUser::findOne($model['userid']);

                $usermodel->score += $score;

                /**
                 * 2、更新用户等级
                 */
                $vipmodel = Vips::find()->where(['>=', 'score', $usermodel->score])->orderBy('sort asc')->one();

                $usermodel->vip = $vipmodel['id'];

                $usermodel->save();

                /**
                 * 3、生成流水账单
                 */
                $bill = new OrderBill();
                $addmessage= [

                    'order_number'=>$model['order_number'],
                    'price'=>$model['sum_price'],
                    'type'=>1,
                ];
                $bill->setAttributes($addmessage);
                $bill->save();
                /**
                 * 4、更新资金总额
                 */
                $intelModel =  IntelData::findOne(1);
                $intelModel->gold += $model['sum_price'];
                $intelModel->gold_history += $model['sum_price'];
                $intelModel->save();
                /**
                 * 5、生成订单日志
                 */
                $log = new OrderLog();
                $add = [
                    'order_id' => $model->id,
                    'order_number' => $model->order_number,
                    'uid' =>$model->userid,
                    'status' => $model->type,
                    'label' => '订单第二次交易成功。',
                ];
                $log->setAttributes($add);
                $log->save();
                Yii::info('业务处理结束（第二次付款成功）','order');
                return true;
            }

            Yii::info('业务处理异常（无效订单状态）','order');
            Yii::info(['type'=>$model->type],'order');
            return false;
        });


    }

    public function actionMakePay()
{

        $getdata = \Yii::$app->request->post();
        Yii::info('微信下单','order');
//        Yii::info(['order_number'=>$getdata['order_number']],'order');
         /*$getdata = [
             'order_number'=>'2017070310154985',      //订单主键
             'family_id'=>41,
             'exam_people'=>'下路口',
             'full_address'=>'浙江省下路口',
             'sum_price'=>912,
             'guider'=>'高端导医',
             'is_invoice'=>'是',
             'message'=>'留言',
             'fare'=>12,
             'guide_price'=>800,
             'price'=>100,
         ];*/

        if (empty($getdata['order_number']))
        {
            return response(10001,'无效数据');
        }

        /**
         * 获取订单数据
         */
        $order = Order::find()->where(['order_number'=>$getdata['order_number']])->one();
        if (empty($order->id))
        {
            return response(20002,'无效订单');
        }
        if (!in_array($order->type,[1,9]))
        {
            return response(20022,'非法操作');
        }
        if($order->type ==9){
//            var_dump($getdata['family_id']);die;
            $order->setAttributes($getdata);
//            var_dump($order);die;
            $order->save();
        }
//        var_dump($order['sum_price']);die;
//        if ($order['sum_price'] != $getdata['sum_price'])
//        {
//            return response(20003,'金额错误');
//        }
        //如果JSAPI存在的话直接读取数据库中的微信签名
//        if (!empty($order->wechat_apidata))
//        {
//            $res_data = json_decode($order->wechat_apidata);
//            return response(0,'',$res_data);
//        }
        //初始赋值
        $sum_price = 0;
        $order_number = $getdata['order_number'];

        switch ($order->type){
            case 1:
                if($order->order_type ==2){
                    //个性化订单
                    $sum_price = $order->deposit;
                }
                else{
                    $sum_price = $order->sum_price;
                }
                break;
            case 9:
                $sum_price = $order->sum_price;
                $order_number = $order->second_number;
                break;
            default:
                return response(20025,'非法操作');
                break;
        }

        Yii::info(['make order number'=>$order_number],'order');
//        var_dump($order_number);die;

        /**
         * 生成支付订单
         * @var unknown
         */
        $app = new Application(\Yii::$app->params['WECHAT']);

        $payment = $app->payment;
        /**
         * 产品数据 数据库读取
         * @var  unknown
         */
        $attributes = [
            'trade_type' => 'APP', // JSAPI，NATIVE，APP...
//            'body'  => $order['item']['title'].' '.$order['plan']['name'],  //商品描述
            'body' => '健康6S体检套餐',
//            'detail' => $order['item']['title'].' '.$order['plan']['name'],     //商品详情
            //             'attach',    //附加数据
            'out_trade_no' => $order_number,   //商户订单号
            //             'fee_type',  //标价币种
            'total_fee' => $sum_price*100, // 标价金额 单位：分,
//            'total_fee' => 1,
            //             'spbill_create_ip',      //终端ip
            //             'time_start',    //交易起始时间
            //             'time_expire',   //交易结束时间
            //             'goods_tag',     //商品标记
            //             'notify_url',    //回调地址
            //             'trade_type',    //交易类型
            //             'product_id',    //商品主键
            //             'limit_pay',     //指定支付方式
//            'openid'=> $getdata['openid'],
            //             'sub_openid',
            //             'auth_code',
        ];
        $orderModel = new \EasyWeChat\Payment\Order($attributes);
        //统一下单 ，完成订单创建
        $result = $payment->prepare($orderModel);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            $prepayId = $result->prepay_id;
//        $jsApiConfig = $payment->configForPayment($prepayId,false);
            $config = $payment->configForAppPayment($prepayId, false);
//        $token =  $app->access_token->getToken();
//            $configForPickAddress = $payment->configForShareAddress($token,false);

//            $res_data['jsApiConfig'] = $jsApiConfig;
//            $res_data['editAddress'] = $jsApiConfig;
            $res_data['jsApiConfig'] = $config;
            $order->wechat_apidata = json_encode($res_data);
            $order->save();
            Yii::info('微信下单参数生成成功','order');
            return response(0, '', $res_data);
        }
        $log = new OrderLog();
        $add = [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'uid' =>$order->userid,
            'status' => $order->type,
            'label' => '微信下单参数生成失败。',
        ];
        $log->setAttributes($add);
        $log->save();
        Yii::info('微信下单参数生成失败了','order');
        return response(20010, '系统繁忙，请等待几分钟后重试', $result);

}
//    /**
//     * 生成微信订单
//     */
//
//    public function actionWxmake()
//    {
//        $getdata = Yii::$app->request->post();
//        $getdata = [
//            'order_number'=>'2017070310154985',
//        ];
//        $getdata['userid'] = $this->userMsg['id'];
//        $item_name = "健康6S-体检套餐";
//
//        $order = Order::find()->where(['userid'=>$getdata['userid']])->andWhere(['order_number'=>$getdata['order_number']])->asArray()->one();
//        if (!$order) {
//            return response(816001,"请求的订单不存在!");
//        }
////        var_dump($order['type']);die;
//        if (!in_array($order['type'],[1,9])) {
//            return response(816003,"疑似重复提交订单!");
//        }
//        $order_number = $order['order_number'];
//
//
//        //判断是不是已经在微信下单过
////        $log_info = WxpayLog::find()->where(['mpid'=>$req_arr['mpid']])->asArray()->one();
////
////        if ($log_info) {
////            $diff = strtotime($log_info['create_time']) + 60*60*2;
////            if ($diff >= time()) {
////                return response(0,"success.",$log_info);
////            }
////        }
//
//        $wxpayapi = new \WxPayApi();
//        $order = new \WxPayUnifiedOrder();
//
//        $order->SetOut_trade_no($order_number);
//        $order->SetBody($item_name);
//        $order->SetTotal_fee($order['sum_price']*100);       //注意金额是分!
//        $order->SetTrade_type("APP");
//        $order->SetNotify_url(Yii::$app->params['ApiDomain']."/pay/wxpay/notify"); //http://api.hangwt.cn/pay/wxpay/notify
//
//        $ret = $wxpayapi->unifiedOrder($order);
//        if (!isset($ret['return_code']) || $ret['return_code']!=="SUCCESS") {
//            Yii::info('微信下单接口返回错误,返回信息:'.json_encode($ret,JSON_UNESCAPED_UNICODE),'wxpay');
//            return response(816002,"微信下单失败");
//        }
//
//        if (!isset($ret['appid'])) {
//            $appid = "wx7dca056abe872fac";
//        } else {
//            $appid = $ret['appid'];
//        }
//
//        if (!isset($ret['mch_id'])) {
//            $mch_id = "1485755122";
//        } else {
//            $mch_id = $ret['mch_id'];
//        }
//
//        if (!isset($ret['prepay_id'])) {
//            Yii::info('微信下单接口参数不完整,返回信息:'.json_encode($ret,JSON_UNESCAPED_UNICODE),'wxpay');
//            return response(816002,"微信下单接口参数不完整");
//        }
//
////        $model = new WxpayLog();
//
//
//        $wxdatabase = new \WxPayDataBase();
//        $time = time();
//        $wxdatabase->SetValues([
//            'appid'=>$appid,
//            'partnerid'=>$mch_id,
//            'prepayid'=>$ret['prepay_id'],
//            'package'=>'Sign=WXPay',
//            'noncestr'=>$ret['nonce_str'],
//            'timestamp'=>$time,
//        ]);
//        $wxdatabase->SetSign();
//
//
////        $save_data = [
////            'appid'=>$appid,
////            'partnerid'=>$mch_id,
////            'prepay_id'=>$ret['prepay_id'],
////            'package'=>'Sign=WXPay',
////            'nonce_str'=>$ret['nonce_str'],
////            'sign'=>$ret['sign'],
////            'trade_type'=>$ret['trade_type'],
////            'mpid'=>$req_arr['mpid']
////        ];
//
////        $model->setAttributes($save_data);
////        if (!$model->save()) {
////            Yii::info('微信下单接口保存失败了,参数:'.json_encode($save_data),'wxpay');
////            return response(9999,"内部错误了");
////        }
////        print_r($ret);
//        return response(0,"success.",$wxdatabase->GetValues());
//    }
    //日志记录
    protected  function PayLog($content='')
    {

        $model =   new Content();
        $addMsg = [
            'type'=>'3',
            'content'=>$content,
        ];
        $model->setAttributes($addMsg);
        $model->save();

        return true;
    }
////退款
//    public function actionRefund()
//
//    {
//        $getdata = \Yii::$app->request->post();
//        /*$getdata = [
//            'order_number' => '2017062597579754',
//        ];*/
//        $model = Order::find()->where(['order_number' => $getdata['order_number']])->one();
//        /**
//         * 1、生成流水账单
//         */
//        $bill = new OrderBill();
//        $addmessage = [
//            'userid' => $getdata['userid'],
//            'order_number' => $model['order_number'],
//            'price' => $model['sum_price'],
//            'type' => 2,
//        ];
//        $bill->setAttributes($addmessage);
//        $bill->save();
//        /**
//         * 2、更新资金总额
//         */
//        $intelModel = IntelData::findOne(1);
//        $intelModel->gold -= $model['sum_price'];
//        $intelModel->gold_history += $model['sum_price'];
//        $intelModel->save();
//
//        if ($model->type == 2 || $model->type == 8) {
//            $model->type = 6;
//            $model->save();
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    /**
//     * 模拟支付成功页面
//     * Renders the index view for the module
//     * @return string
//     */
//    public function backPay($order_id=NULL,$price =NULL)
//    {
////         $getdata = \Yii::$app->request->post();
//        $getdata = [
//            'order_id'=>$order_id,       //订单主键
//            'price' => $price,     //付款金额
//        ];
//        if ( empty($getdata['price']) || empty($getdata['order_id']))
//        {
//            $this->PayLog('参数错误');
//            return false;
////             return response(20001,'无效数据');
//        }
//        $order = \rpitem\modules\order\models\Order::find()->where(['id'=>$getdata['order_id'],'status'=>3])->one();
//        if (empty($order->id))
//        {
//            $this->PayLog('订单数据查询不到'.$getdata['order_id']);
//            return false;
////             return response(20002,'无效订单');
//        }
//        $order->status = 4;
//        if ($order->save())
//        {
//
//        }
//        else {
//            //订单失败、退款流程
//            return true;
////             return response(20003,'订单错误， 正在退款');
//        }
//        $mymodel = $order;
//        /**
//         * 调用API接口实现保单提交（无加密方式）
//        */
//        $baodan_data = [
//            'Head'=>[
//                "AppName"=>"JCB",       //由平台授权的登录用户名
//                "Password"=>"mcly123456"    //由平台授权的登录用户密码
//            ],
//            "Body"=>[   //保险报单的公共信息部分
//                'OrderCode'=>$mymodel->order_code,  //订单编号，每次提交不能重复
//                'OrderType'=>Items::findOne($mymodel->item_id)->order_type, //保单的险种套餐类别，具体见基础数据
//                'StartDate'=>$mymodel->start_time,  //保单生效的起始时间
//                'EndDate'=>$mymodel->end_time,  //保险的截止时间
//                'CodInd'=>'N',   //见费出单标记。（Y:是）（N:否）
//                'uWCount'=>1,   //购买保险的份数
//            ],
//            "RelatedParty"=>[   //投保人信息
//                "InsuredName" => $mymodel->from_name,   //投保人姓名
//                "IdentifyNumber" => $mymodel->from_id_card,     //投保人证件号码
//                "IdentifyType"=>"01"     //证件类别（详见基础数据）01	居民身份证
//            ],
//            "RiskRealatePary" => [    //被保险人以及受益人信息
//                "ClientCName"=>$mymodel->to_name,   //被保险人姓名
//                "IdentifyNo"=>$mymodel->to_id_card,     //被保险人证件号码
//                "IdentifyType"=>"01",    //被保险人证件类别（详见基础数据）
//                "ClientCNameBenefit"=>$mymodel->benefit_name, //受益人姓名
//                "IdentifyNoBenfit"=>$mymodel->benefit_id_card,   //受益人证件号码
//                "IdentifyTypeBenefit"=> "01" ,    //受益人证件类别（详见基础数据）
//            ],
//        ];
//
//        /**
//         * 调用保险下单api ， 若下单失败，则走退款流程
//         */
//        $saas_data =  wechatHttpsRequest(\Yii::$app->params['sass_api'].'api/Personal/Add',json_encode($baodan_data));
//        $this->PayLog('保险公司接口发送数据：'.json_encode($baodan_data));
//        $this->PayLog('保险公司接口返回数据：'.$saas_data);
//        if (!empty($saas_data))
//        {
//            $saas_data = json_decode($saas_data,true);
//            if (!empty($saas_data['Head']['ResponseCode']) && ($saas_data['Head']['ResponseCode'] == "0000"))
//            {
//                //购买成功
//
//                $order->ftr_no = $saas_data['Body']['FtrNo'];
//                $order->policy_no = $saas_data['Body']['PolicyNo'];
//                $order->save();
//            }
//            else
//            {
//                //返回数据失败
//                $saas_data =  wechatHttpsRequest('http://113.10.244.214:81/api/Personal/Add',json_encode($baodan_data));
//
//                if (!empty($saas_data))
//                {
//                    $saas_data = json_decode($saas_data,true);
//                    if (!empty($saas_data['Head']['ResponseCode']) && ($saas_data['Head']['ResponseCode'] == "0000"))
//                    {
//                        //购买成功
//
//                        $order->ftr_no = $saas_data['Body']['FtrNo'];
//                        $order->policy_no = $saas_data['Body']['PolicyNo'];
//                        $order->save();
//                    }
//                    else
//                    {
//                        //走退款流程
//                        $this->PayLog('订单失效，开始退款：');
//                        return true;
//                    }
//                }
//                else {
//                    //走退款流程
//                    $this->PayLog('订单失效，开始退款3：');
//                    return true;
//                }
//            }
//        }
//        else
//        {
//            //走退款流程
//            $this->PayLog('订单失效，开始退款2：');
//            return true;
//        }
//        $this->PayLog('加入销售奖励,先验证是否已经存在记录');
//        //加入销售奖励,先验证是否已经存在记录
//        if (empty(AgencyUserBill::find()->where(['agency_user_id'=>$order->agency_user_id,'order_id'=>$order->id])->asArray()->one()))
//        {
//            $sell_model = new AgencyUserBill();
//            $sellMsg = [
//                'remark' => '销售奖励',
//                'price' => $order->sell_price,
//                'type' => 1,
//                'agency_user_id' => $order->agency_user_id,
//                'order_id' => $order->id,
//                'status' => 1,
//            ];
//            $sell_model->setAttributes($sellMsg);
//            if ($sell_model->save())
//            {
//                //代理收益记录修改
//                $agencys_usermodel = AgencysUser::findOne($order->agency_user_id);
//                if (!empty($agencys_usermodel->id))
//                {
//                    $agencys_usermodel->gold +=  $order->sell_price;
//                    $agencys_usermodel->gold_history +=  $order->sell_price;
//
//                    $agencys_usermodel->save();
//                    Notice::sendNotice('销售返利提醒', '恭喜您成功销售一份保险产品， 返利将在保险生效后充值到您的可提现账户中', $agencys_usermodel->id,100);
//
//
//                }
//
//            }
//        }
//        else {
//            return true;
////             return response(20004,'重复订单');
//        }
//        $this->PayLog('推广奖励记录');
//        //、推广奖励记录
//        if (($order->agency_user_pid > 0) && empty(AgencyUserBill::find()->where(['agency_user_id'=>$order->agency_user_pid,'order_id'=>$order->id])->asArray()->one()))
//        {
//            $spread_model = new AgencyUserBill();
//            $spreadMsg = [
//                'remark' => '推广奖励',
//                'price' => $order->spread_price,
//                'type' => 1,
//                'agency_user_id' => $order->agency_user_pid,
//                'order_id' => $order->id,
//                'status' => 1,
//            ];
//            $spread_model->setAttributes($spreadMsg);
//            //             $spread_model->save();
//            if ($spread_model->save())
//            {
//                //代理收益记录修改
//                $agencys_usermodel = AgencysUser::findOne($order->agency_user_pid);
//                if (!empty($agencys_usermodel->id))
//                {
//                    $agencys_usermodel->gold +=  $order->spread_price;
//                    $agencys_usermodel->gold_history +=  $order->spread_price;
//
//                    $agencys_usermodel->save();
//                    Notice::sendNotice('合伙人奖励提醒', '恭喜您的合伙人成功销售一份保险产品， 推广返利将在保险生效后充值到您的可提现账户中', $agencys_usermodel->id,50);
//
//                }
//            }
//        }
//        /**
//         * 中介公司收益记录
//         */
//        $this->PayLog('中介公司收益记录');
//        if (empty(AgencyBill::find()->where(['order_id' => $order->id,'agency_id'=>$order->agency_id])->asArray()->one()))
//        {
//            $com_model = new AgencyBill();
//            $comMsg = [
//                'remark' => '推广奖励',
//                'price' => $order->com_price,
//                'type' => 1,
//                'agency_id' => $order->agency_id,
//                'order_id' => $order->id,
//                'status' => 1,
//            ];
//            $com_model->setAttributes($comMsg);
//
//            if ($com_model->save())
//            {
//                //中介收益记录修改
//                $agencys_model = AgencyData::find()->where(['agency_id' => $order->agency_id])->one();
//                if (!empty($agencys_model->agency_id))
//                {
//                    $agencys_model->gold +=  $order->com_price;
//                    $agencys_model->gold_history +=  $order->com_price;
//                    $agencys_model->save();
//                }
//            }
//        }
//
//        /**
//         * 修改平台产品销量、中介产品销量
//         */
//        $this->PayLog('修改平台产品销量、中介产品销量');
//
//        $intelItemModel = Items::findOne($order->item_id);
//        if (!empty($intelItemModel->id))
//        {
//            $intelItemModel->sum_num += 1;
//            $intelItemModel->save();
//        }
//        $this->PayLog('agency_id:'.$order->agency_id.'id'.$order->id.'item_id'.$order->item_id);
//        $agencyItemModel = AgencyItems::find()->where(['status'=>1,'agency_id'=>$order->agency_id,'item_id'=>$order->item_id])->one();
//        if (!empty($agencyItemModel->id))
//        {
//            $agencyItemModel->sum_num += 1;
//            $agencyItemModel->agency_list = ''.$agencyItemModel->id;
//            $agencyItemModel->save();
//        }
//
//        /**
//         * 平台收益记录
//         */
//        $this->PayLog('平台收益记录');
//        if (empty(IntelBill::find()->where(['order_id' => $order->id])->asArray()->one()))
//        {
//
//            $intelbill_model = new IntelBill();
//            $comMsg = [
//                'remark' => '销售奖励',
//                'price' => $order->intel_price,
//                'type' => 1,
//                'order_id' => $order->id,
//                'status' => 1,
//            ];
//            $this->PayLog('平台收益插入数据记录：'.json_encode($comMsg));
//            $intelbill_model->setAttributes($comMsg);
//            if ($intelbill_model->save())
//            {
//                //平台收益记录修改
//                $intel_model = IntelData::findOne(1);
//                if (!empty($intel_model->id))
//                {
//                    $intel_model->gold +=  $order->intel_price;
//                    $intel_model->gold_history +=  $order->intel_price;
//                    $intel_model->save();
//                }
//            }
//            else
//            {
//
//            }
//        }
//
//
//        return true;
////         return response(0,'');
//
//    }
    
}
