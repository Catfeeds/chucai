<?php

namespace backend\modules\api\controllers;
use yii\rest\Controller;
use backend\modules\member\models\Member;
use yii\base\Object;
use backend\modules\member\models\MemberSearch;
use backend\modules\base\models\EducationalSearch;
use backend\modules\base\models\District;
use backend\modules\base\models\DistrictSearch;
use backend\modules\base\models\Nationality;
use backend\modules\base\models\Educational;
use backend\modules\base\models\ActionLog;
class SystemApiController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 统计数据获取
     */
    public function actionSystemData()
    {
        if (!\Yii::$app->request->isPost) {
        
            return response(10001,'invalid data',[]);
        }
        $getdata = \Yii::$app->request->post();
        $resdata = [
            'user_num'=>0,  //总人数
            'mouth_user_num'=>0,    //月新增人数
            'week_user_num'=>0,     //周新增人数
            'corl_num'=>0,      //总操作次数
        ];
        $model = new MemberSearch();
        
        /**
         * 总人才数
         */
        $data = $model->countSearch($getdata);
        $resdata['user_num'] = $data['sum_num'];
        /**
         * 周增长人才数
         */
        
        $getdata['start_time'] = date("Y-m-d h:i:s",strtotime("-1 week"));
        $data = $model->countSearch($getdata);
        $resdata['mouth_user_num'] = $data['sum_num'];
        /**
         * 月增长人才数
         */
        $getdata['start_time'] = date("Y-m-d h:i:s",strtotime("-1 month"));
        $data = $model->countSearch($getdata);
        $resdata['week_user_num'] = $data['sum_num'];
        
        /**
         * 总操作次数
         */
        $data = ActionLog::find()->select(['sum_num'=>'count(*)'])->where(['uid'=>\Yii::$app->user->id])->asArray()->one();
        $resdata['corl_num'] = $data['sum_num'];
        return response(0,'success',$resdata);
    }
    
    /**
     * 性别分布接口实现
     */
    public function actionSexData() 
    {
        if (!\Yii::$app->request->isPost) {
        
            return response(10001,'invalid data',[]);
        }
        $getdata = \Yii::$app->request->post();
//         $getdata = [
//             'dt_id'=>1,
//             'sh_id'=>1,
//             'na_id'=>1,
//             'start_time'=>'2015-01-07 10:54:01',
//             'end_time'=>'2017-02-05 15:54:01',
//         ];
 
        $model = new MemberSearch();
        $resdata = $model->sexSearch($getdata);
        return response(0,'success',$resdata);
    }
    
    /**
     * 学历分布接口实现
     */
    public function actionEduData()
    {
        if (!\Yii::$app->request->isPost) {
        
            return response(10001,'invalid data',[]);
        }
        $getdata = \Yii::$app->request->post();
//         $getdata = [
// //             'dt_id'=>1,
// //             'sex'=>1,
// //             'na_id'=>1,
// //             'start_time'=>'2015-06-07 10:54:01',
// //             'end_time'=>'2017-09-07 10:54:01',
//         ];
        $model = new MemberSearch();
        $resdata = $model->eduSearch($getdata);
        $namearr = array();
        $resarr = array();
        foreach ($resdata as $v)
        {
            $namearr[$v['sh_id']] = $v['name'];
            $resarr[$v['sh_id']] = $v['sum_num'];
        }
        
        $distarr = Educational::items();
         
        $datainfo = array();
        foreach ($distarr as $key=>$v)
        {
            if (in_array($v,$namearr))
            {
                $datainfo[] = [
                    'sum_num'=>$resarr[$key],
                    'sh_id'=>$key,
                    'name'=>$v
                ];
            }
            else {
                $datainfo[] = [
                    'sum_num'=>0,
                    'sh_id'=>$key,
                    'name'=>$v
                ];
            }
        }
         
        
        
        return response(0,'success',$datainfo);
         
    }
    
    /**
     * 区域分布接口实现
     */
    public function actionAreaData()
    {
        if (!\Yii::$app->request->isPost) {
        
            return response(10001,'invalid data',[]);
        }
        $getdata = \Yii::$app->request->post();
//         $getdata = [
//             'sex'=>1,
// //             'sh_id'=>2,
// //             'na_id'=>1,
// //             'start_time'=>'2015-06-07 10:54:01',
// //             'end_time'=>'2017-06-07 10:54:01',
//         ];
        if (!empty($getdata['start_time'])) {
            $getdata['start_time'] .= " 00:00:01";
        }
        if (!empty($getdata['end_time'])) {
            $getdata['end_time'] .= " 23:59:59";
        }
        
        $model = new MemberSearch();
        $resdata = $model->areaSearch($getdata);
        $namearr = array();
        $resarr = array();
        foreach ($resdata as $v)
        {
            $namearr[$v['dt_id']] = $v['name'];
            $resarr[$v['dt_id']] = $v['sum_num'];
        }
//         $namearr = array_column($resdata, 'name');
//         var_dump($namearr);die;
        
        $distarr = District::items(true);
         
        $datainfo = array();
        foreach ($distarr as $key=>$v)
        {
            if (in_array($v,$namearr))
            {
                $datainfo[] = [
                    'sum_num'=>$resarr[$key],
                    'dt_id'=>$key,
                    'name'=>$v
                ];
            }
            else {
                $datainfo[] = [
                    'sum_num'=>0,
                    'dt_id'=>$key,
                    'name'=>$v
                ];
            }
        }
        
         
        
        return response(0,'success',$datainfo);
      
        
    }
    
    
    /**
     * 特殊区域分布接口实现
     */
    public function actionSpeAreaData()
    {
        if (!\Yii::$app->request->isPost) {
    
            return response(10001,'invalid data',[]);
        }
        $getdata = \Yii::$app->request->post();
        //         $getdata = [
        //             'sex'=>1,
        // //             'sh_id'=>2,
        // //             'na_id'=>1,
        // //             'start_time'=>'2015-06-07 10:54:01',
        // //             'end_time'=>'2017-06-07 10:54:01',
        //         ];
        if (!empty($getdata['start_time'])) {
            $getdata['start_time'] .= " 00:00:01";
        }
        if (!empty($getdata['end_time'])) {
            $getdata['end_time'] .= " 23:59:59";
        }
    
        $model = new MemberSearch();
        
//         $resdata = $model->specAreaSearch($getdata);
        $dataArray = [
            '上海',
            '北京',
            '杭州'
        ];
        foreach ($dataArray as $v) {
            unset($info);
            $getdata['job_address'] = $v;
            $info = $model->specAreaSearch($getdata);
            $datainfo[] =[
                'sum_num'=>$info['sum_num'],
                'name'=>$v
            ];
        }
        return response(0,'success',$datainfo);
    
    
    }
    
    
}
