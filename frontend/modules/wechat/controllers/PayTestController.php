<?php

namespace frontend\modules\wechat\controllers;

/**
 * User: zwp
 * Remark: 优惠券变更状态，退款接口
 * Date: 2017-07-21 14:05:06
 * Copyright (c) 2016-2017 *********猎米网络科技有限公司技术开发部
 */
 
use backend\modules\coupon\models\Coupon;
use backend\modules\coupon\models\CouponUser;
use backend\modules\order\models\IntelData;
use backend\modules\order\models\Order;
use backend\modules\order\models\OrderBill;
use backend\modules\order\models\OrderLog;
use backend\modules\ruiuser\models\RuiUser;
use backend\modules\ruiuser\models\Vips;
use common\components\BaseApiController;




/**
 * Default controller for the `pay` module
 */
class PayTestController extends BaseApiController

{
    //优惠券变更状态
    public function actionCallBack()
    {
        $getdata = \Yii::$app->request->post();
        /*$getdata = [
            'order_number' => '2017070310154985',
            'code'=>'8dbc87cdeea425a926d6f96581a4db38'
        ];*/
        $getdata['userid'] = $this->userMsg['id'];
//        var_dump($getdata);die;
        $model = Order::find()->where(['order_number' => $getdata['order_number']])->one();
            if ($model->type == 1) {
                $model->type = 3;

                $model->save();
                /**
                 *优惠券使用标记变更
                 */
                $c_user = CouponUser::find()->joinWith(['order'])->where(['code' => $getdata['code']])->one();
//                var_dump($c_user);die;
                if (!empty($c_user)) {
                    $c_user->status = 2;
                    $c_user->save();
                }
                return response(0,'success');
            }

    }

    //用户退款接口
    public function actionRefund()

    {
        $getdata = \Yii::$app->request->post();
        /*$getdata = [
            'order_number' => '2017062597579754',
        ];*/
        $getdata['userid'] = $this->userMsg['id'];
        $model = Order::find()->where(['order_number' => $getdata['order_number']])->one();
        /**
         * 1、生成流水账单
         */
        $bill = new OrderBill();
        $addmessage= [
            'userid'=>$getdata['userid'],
            'order_number'=>$model['order_number'],
            'price'=>$model['sum_price'],
            'type'=>2,
        ];
        $bill->setAttributes($addmessage);
        $bill->save();
        /**
         * 2、更新资金总额
         */
        $intelModel =  IntelData::findOne(1);
        $intelModel->gold -= $model['sum_price'];
        $intelModel->gold_history += $model['sum_price'];
        $intelModel->save();

        /**
         * 3、生成订单日志
         */

        $log = new OrderLog();
        $add = [
            'order_id' => $model->id,
            'order_number' => $model->order_number,
            'uid' =>$model->userid,
            'status' => $model->type,
            'label' => '用户申请退款',
        ];
        $log->setAttributes($add);
        $log->save();
        if ($model->type == 2 || $model->type == 8) {
            $model->type = 6;
            $model->save();
            return true;
        }
        else{
            return false;
        }


    }

}





