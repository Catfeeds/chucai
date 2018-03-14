<?php

namespace wechat\modules\wechat\controllers;
 
use wechat\modules\wechat\models\WechatText;
use common\models\User;
use common\widgets\Alert;
use yii\base\Object;
use wechat\modules\member\models\UserData;
use wechat\modules\wechat\models\WechatSend;
// use yii\web\Controller;
 
// use yii;
class WechatController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        echo "123";die;
        
        return $this->render('index');
    }
    /**
     * 获取用户数据/事件，进行数据统计
     */
    public function actionWechatInfo()
    {
        $echostr = \Yii::$app->request->get('echostr',null);
        $xml = \Yii::$app->request->get('xml',null);
        $messageSignature = \Yii::$app->request->get('messageSignature',null);
        $timestamp = \Yii::$app->request->get('timestamp',null);
        $nonce = \Yii::$app->request->get('nonce',null);
        $encryptType = \Yii::$app->request->get('encryptType',null);
        
        $wechat = \Yii::$app->wechat;
        $data = array();
        $data = $wechat->parseRequestXml($xml, $messageSignature, $timestamp , $nonce, $encryptType);
        if (empty($data))
        {
            return $echostr;
        }
        /**
         * 将接受到的数据存入数据库
         */
        $model = new WechatText();
        $saveMsg['content'] = json_encode($data);
        $model->setAttributes($saveMsg);
        if ($model->validate())
        {
            $model->save();
        }
        
        /**
         * 对关注事件进行处理
         */
        if (!empty($data['Event']))
        {
            if ($data['Event'] == 'subscribe')
            {
                //自动注册会员
                $wx_userMsg = $wechat->getUserInfo($data['FromUserName']);
                $this->signup($wx_userMsg);
                
                $this->sendPmShow($data['FromUserName']);
            }
        }
        
  /*       switch ($data['MsgType'])
        {
            case 'text':        //文本消息
                break;
            case 'event':        //推送事件
                //对关注事件进行推送处理
                
                break;
            default:
                break;
        } */
        
        
       return $echostr;
    }
     
    
    
    private function  signup($param=array())
    {
        if (empty($param))
        {
            return false;
        }
        /**
         * 验证用户是否已经存在
         */
        $userModel = new UserData();
        
        if (!empty($userModel->find()->where(['openid'=>$param['openid']])->one()))
        {
            return true;
        }
        /**
         * 随机生成用户
         * @var unknown
         */
        $username = $this->getVerifyCode(8);
        $user = \Yii::createObject(User::className());
        $user->username = $username;
        $user->email = $username.'@163.com';
        $user->setPassword('888888');
        $user->generateAuthKey();
        $user->save();
        
        $saveMsg = [
            'openid'=>$param['openid'],
            'uid'=>$user->id,
            'head_url'=>$param['headimgurl'],
            'nick_name'=>$param['nickname'],
            'sex' => $param['sex'],
            'parent_id'=>10000,
        ];
         
        
        $userModel->setAttributes($saveMsg);
        $userModel->save();
        return $saveMsg;


    }
    
    protected function getVerifyCode($length=6)
    {
        $chars = [
            'A','B','F','W','X','Z','M','N','T','H','K','0','1','2','3','4','5','6','7','8','9'
        ];
    
        // 在 $chars 中随机取 $length 个数组元素键名
        $keys = array_rand($chars, $length);
    
        $verify_code = '';
        for($i = 0; $i < $length; $i++)
        {
            // 将 $length 个数组元素连接成字符串
            $verify_code .= $chars[$keys[$i]];
        }
        return $verify_code;
    }
    /**
     * 欢迎页测试
     * @param unknown $openid
     */
    public function actionSendTest()
    {
        $openid = 'ondtVwdwJ3l8C4lr73lgBMrzTggs';
        $data = $this->sendPmShow($openid);
        if ($data)
        {
            return  $data;
        }
        else
        {
            return "fail";
        }
        exit;
    }
    
    private function sendPmShow($openid) {
        
        $wechatModel = WechatSend::find()->where(['template_id'=>'Bo_5P4j2dxsAx2LWNZzJK7zzQnWtJZJBmf9dGrNSPRQ'])->orderBy('create_time desc')->one();
        if (!empty($wechatModel))
        {
            $data = [
                    'touser'=> $openid,
                    'url'=>$wechatModel->url,
                    'template_id'=>'Bo_5P4j2dxsAx2LWNZzJK7zzQnWtJZJBmf9dGrNSPRQ',
                    'data'=>[
                        'first'=>[
                            'value'=>$wechatModel->first_value,
                            'color'=>$wechatModel->first_color
                        ],
                        'keyword1'=>[
                            'value'=>$wechatModel->keyword1_value,
                            'color'=>$wechatModel->keyword1_value
                        ],
                        'keyword2'=>[
                            'value'=>$wechatModel->keyword2_value,
                            'color'=>$wechatModel->keyword2_value
                        ],
                        'keyword3'=>[
                            'value'=>$wechatModel->keyword3_value,
                            'color'=>$wechatModel->keyword3_value
                        ],
                        'remark'=>[
                            'value'=>$wechatModel->remark_value,
                            'color'=>$wechatModel->remark_value
                        ]
                    ]
                ];
        }
        else {
            $data = [
                'touser'=>$openid,
                'url'=>'http://www.ztnet.com.cn/',
                'template_id'=>'Bo_5P4j2dxsAx2LWNZzJK7zzQnWtJZJBmf9dGrNSPRQ',
                'data'=>[
                    'first'=>[
                        'value'=>'欢迎加入掌易派，快快点击“会员”按钮成为我们的会员吧！',
                        'color'=>'#173177'
                    ],
                    'keyword1'=>[
                        'value'=>'掌易派',
                        'color'=>'#173177'
                    ],
                    'keyword2'=>[
                        'value'=>'掌易派是一个公司寻找早期投资人/合伙人的平台。 我们注入情感设计，寻求每一次创意的突破，从而提升产品体验的愉悦！！！',
                        'color'=>'#173177'
                    ],
                    'keyword3'=>[
                        'value'=>'合伙人',
                        'color'=>'#173177'
                    ],
                    'remark'=>[
                        'value'=>'点击查看公司详情',
                        'color'=>'#173177'
                    ]
                ]
            ];
        }
        
        $wechat = \Yii::$app->wechat;
        
        $res_data = $wechat->sendTemplateMessage($data);
        return $data;
    }

    

}
