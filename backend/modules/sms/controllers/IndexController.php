<?php

namespace backend\modules\sms\controllers;

// use backend\modules\sms\models\Message;
use Yii;
use yii\web\HttpException;
use backend\modules\sms\models\Verifycode;
 
use gmars\sms\Sms;
use yii\rest\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $model = new Verifycode();
        $model->setAttributes(['phone'=>"15158068055"]);

        if (!$model->send()) {
            return response(999,$model->errors);
        }

        return response();
//        $api_send_url = "http://api.china95059.net:8080/sms/send";
//
//        $api_username = "wgjt1";
//        $api_password = "wgjt1001";
//
//        $msg = "这是您的验证码6666";
//        $mobile = "15158068055";
//        $needstatus = true;
//        $sender = '';
//        $type = "json";
//
//        $postArr = [
//            'name' => $api_username,
//            'pswd' => $api_password,
//            'msg' => $msg,
//            'mobile' => $mobile,
//            'needstatus' => $needstatus,
//            'sender' => $sender,
//            'type' => $type
//        ];
//        $ret = request($api_send_url,$postArr);
//        print_r($ret);
//        return response();
    }

    //发送注册验证码
    public function actionRegister()
    {
        
        $req = Yii::$app->request;
        if (!Yii::$app->request->isPost) {
            throw new  HttpException(400);
        }

        $model = Yii::createObject(Verifycode::className());
        $model->setAttributes($req->post());
        if (!$code = $model->send('register')) {
            return response(1101,$model->errors['errmsg']);
        }

        return response();
    }
    
    //发送注册验证码
    public function actionLogin()
    {
        $req = Yii::$app->request;
        if (!Yii::$app->request->isPost) {
            throw new  HttpException(400);
        }
    
        $model = Yii::createObject(Verifycode::className());
        $model->setAttributes($req->post());
        if (!$code = $model->send('login')) {
            return response(1101,$model->errors['errmsg']);
        }
    
        return response();
    }
    

    //发送找回密码验证码
    public function actionForget(){
        $req = Yii::$app->request;
        if (!Yii::$app->request->isPost) {
            throw new  HttpException(400);
        }

        $model = Yii::createObject(Verifycode::className());
        $model->setAttributes($req->post());
        if (!$code = $model->send(1)) {
            return response(1101,$model->errors['errmsg']);
        }

        return response();
    }

    //发送重置密码验证码
    public function actionReset(){
        $req = Yii::$app->request;
//        if (!Yii::$app->request->isPost) {
//            throw new  HttpException(400);
//        }

        $model = Yii::createObject(Verifycode::className());
        $model->setAttributes($req->post());
        if (!$code = $model->send('reset')) {
            return response(1101,$model->errors['errmsg']);
        }

        return response();
    }
    
    
    //发送设置密码验证码
    public function actionSetpay(){
        $req = Yii::$app->request;
        if (!Yii::$app->request->isPost) {
            throw new  HttpException(400);
        }
    
        $model = Yii::createObject(Verifycode::className());
        $model->setAttributes($req->post());
        if (!$code = $model->send('setpay')) {
            return response(1101,$model->errors['errmsg']);
        }
    
        return response();
    }

    //重新绑定手机
    public function actionChange(){
        $req = Yii::$app->request;
        if (!Yii::$app->request->isPost) {
            throw new  HttpException(400);
        }

        $model = Yii::createObject(Verifycode::className());
        $model->setAttributes($req->post());
        if (!$code = $model->send('change')) {
            return response(1101,$model->errors['errmsg']);
        }

        return response();
    }
    
    /**
     * 短信发送测试
     */
    public function actionTestSend()
    {
//         var_dump(\Yii::$app->params['ailisms']);die;
       $smsObj =  new Sms('ALIDAYU',['appkey'=>'24503582','secretkey'=>'e041896399a2253c4dd5a6aec3c3343d']);
       $smsObj->send([
           'mobile' => '15168230440',
           'signname' => "瑞梅移动医务室",
           'templatecode' => 'SMS_72490002',
           'data' => [
               'code' => '0',
               'name' => 'zhangwp',
//                'time' => '2'
           ],
       ]);
       
        return response();
    }
}
