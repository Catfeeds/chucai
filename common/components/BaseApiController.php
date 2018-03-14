<?php
/**
 * Created by BaseApiController.php
 *Remarks: 接口公共数据，获取用户信息
 * User: nick
 * Date: 2016年11月15日
 * Time: 上午9:10:05
 * Copyright (c) 2016-2017 *********公司技术开发部
 * version: 
 */

namespace common\components;

use Yii;
use yii\rest\Controller;
 
//use frontend\modules\member\models\UserData;
use backend\modules\ruiuser\models\RuiUser;
/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class BaseApiController extends Controller
{
    public $userMsg=NULL;
    public $userid =NULL;

    public function init()
    {
        $req = Yii::$app->request;
        if (!$req->isPost) {
            // throw new  HttpException(400);
        }
        $req_arr['token'] = $req->post('token',null);
//        $req_arr['token']='54a1495f62a1104008b735974149b07a';
        if(empty($req_arr['token'])){
            echo json_encode(['errcode'=>9999,'errmsg'=>'无效token'],JSON_UNESCAPED_UNICODE);
            exit;
        }
        $now_time = date('Y-m-d H:i:s',time());
        $tokenModel = \backend\modules\base\models\Token::find()->where(['token'=>$req_arr['token']])->andFilterWhere(['<=', 'start_time', $now_time])->andFilterWhere(['>=', 'end_time', $now_time])->asArray()->one();
        if(empty($tokenModel)){
            echo json_encode(['errcode'=>9999,'errmsg'=>'无效token'],JSON_UNESCAPED_UNICODE);
            exit;
        }
            $this->userMsg = $this->getUserMsg($req_arr['token']);
    }
    /**
     * 获取用户信息
     * @return \yii\db\static
     */
    public function getUserMsg($token)
    {
        return RuiUser::find()->joinWith('token')->where(['token.token'=>$token])->asArray()->one();
    }


}
