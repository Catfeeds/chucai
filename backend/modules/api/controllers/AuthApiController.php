<?php

namespace backend\modules\api\controllers;
use Yii;
use yii\rest\Controller;
use backend\modules\member\models\Member;
use backend\modules\member\models\MemberSearch;

class AuthApiController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 申请会员信息
     */
    public function actionApply()
    {
        if (!\Yii::$app->request->isPost) {
        
            return response(10001,'invalid data',[]);
        }
        $getdata = \Yii::$app->request->post();
//         $getdata = [
//             'name' => Yii::t('app', '姓名'),
//             'sex' => 1,
//             'birthday' => '2017-01-12',
//             'na_id' => 1,
//             'sh_id' => 1,
//             'school' => Yii::t('app', '毕业学校'),
//             'job' => Yii::t('app', '现工作及职务'),
//             'job_address' => Yii::t('app', '现工作(学习)单位地址'),
//             'tel' => Yii::t('app', '手机号码'),
//             'wechat' => Yii::t('app', '微信号'),
//             'email' => Yii::t('app', '邮箱'),
//             'telephone' => Yii::t('app', '固定电话'),
//             'resume' => Yii::t('app', '个人学习简历'),
//             'work_history' => Yii::t('app', '工作经历'),
//             'fruits' => Yii::t('app', '个人专业领域、主要成果等'),
//             'service' => Yii::t('app', '创办公司所属行业、主营业务及规模等'),
//             'dt_id' => 1,
//         ];
//         echo json_encode($getdata);die;
        $model = new Member();
        $model->setAttributes($getdata);
        $model->auth_type = 2;
        $model->uid = 10000;
        if ($model->validate())
        {
            $model->save();
        }
        else 
        {
            return response(20002,'数据错误',$model->errors);
        }
        return response(0,'申请成功',[]);
        
    }
    /**
     * 查询数据
     */
    public function actionSearch()
    {
        if (!\Yii::$app->request->isPost) {
    
            return response(10001,'invalid data',[]);
        }
         $getdata = \Yii::$app->request->post();
         $page = \Yii::$app->request->post('page',1);
         $size = \Yii::$app->request->post('size',6);
//         $getdata = [
//             'name' => 'nick',
//             'sex' => 1,
//             'na_id' => 1,
//             'sh_id' => 1,
//             'school' => '杭州电子科技大学',
//             'job' => 'it',
//             'tel' => '15067124172',
//             'wechat' => '15067124172',
//             'email' => '123@163.com',
//             'telephone' => '0571-12345678',
//             'dt_id' => 1,
//             'start_time'=>'2012-01-02 15:03:15',
//             'end_time'=>'2017-08-02 15:03:15',
//         ];       
     
        $searchModel = new MemberSearch();
        $dataProvider = $searchModel->UserSearch($getdata,$page,$size);
//         var_dump($dataProvider);
        return response(0,'success',$dataProvider);
    }
    
    /**
     * 查询人才详细信息
     */
    public function actionMemberInfo()
    {
        if (!\Yii::$app->request->isPost) {
        
           return response(10001,'invalid data',[]);
        }
        $id = \Yii::$app->request->post('id',0);
        $model = new Member();
        $dataProvider = $model->find()->joinWith(['na','sh','dt'])->where(['member.id'=>$id])->asArray()->one();
        
        return response(0,'success',$dataProvider);
    }
    
    
    
    
    
    
    
    
    
    
    

}
