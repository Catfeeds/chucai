<?php

namespace backend\modules\base\controllers;

use backend\models\UeUploadForm;
use backend\modules\base\models\District;
use frontend\modules\member\models\Token;
use Yii;
use yii\web\HttpException;
use common\components\Uploader;
use backend\modules\base\models\Picture;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use yii\base\Object;


/**
 * BuildingController implements the CRUD actions for Building model.
 */
class IndexController extends \yii\rest\Controller
{

    //删除文件素材
    public function actionDelete(){
        return response();
    }

    //区域列表获取接口
    public function actionRegionList(){
        $req = Yii::$app->request;
        if (!$req->isPost) {
            throw new  HttpException(400);
        }

        $req_arr = $req->post();
        if (!Token::checkToken($req_arr)) {
            return response(10000,"无效token");
        }

        if (!isset($req_arr['type'])) {
            throw new  HttpException(400);
        }

        if ($req_arr['type']!=1 && !isset($req_arr['region_id'])) {
            throw new  HttpException(400);
        }
//        print_r($req_arr);die;

        $data = District::getList($req_arr['type'],$req_arr['region_id']);

        return response(0,"",$data);
    }

    //上传素材接口
    public function actionUpload(){
        $req = Yii::$app->request;
        if (!$req->isPost) {
            throw new  HttpException(400);
        }

        $model = new UploadForm();
        $model->file = UploadedFile::getInstance($model,'file');
        if ($model->file == NULL) {
            $model->file = UploadedFile::getInstanceByName('file');
        }
//        print_r($model->file);echo "end";die;

        if (!$data = $model->upload()) {
            return response(123,'上传失败');
        }

        return response(0,"",['url'=>$data['url']]);
    }

//    public function actionUpload($type=1){
//        $req = Yii::$app->request;
//        if (!$req->isPost) {
//            throw new  HttpException(400);
//        }
//
//        $model = new UploadForm();
//        $model->file = UploadedFile::getInstance($model,'file');
//        if ($model->file == NULL) {
//            $model->file = UploadedFile::getInstanceByName('file');
//        }
//
//        if (!$data = $model->upload()) {
//            return $type==100?['state'=>'FAILD']:response(123,'上传失败');
//        }
//
//        return $type==100?$data:response(0,"",['url'=>$data['url']]);
//    }

    //百度富文本文件上传接口
    public function actionUeUpload(){
        $req = Yii::$app->request;
        if (!$req->isPost) {
            throw new  HttpException(400);
        }

        $model = new Picture();
        /**
         * 将图片存入素材库
         * @var unknown
         */
        $getdata  = $this->picuploadlocal('upfile');
        if (empty($getdata))
        {
            return response(20001,'上传失败，请刷新重试',$getdata);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $getdata;
    }

    protected function picuploadlocal($file='file',$model=FALSE)
    {
        $config = [
            'savePath' => \Yii::getAlias('@webroot/image/'), //存储文件夹
            'maxSize' => 2048 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];

        $up = new Uploader($file, $config, 'frontend',$model);


        $info = $up->getFileInfo();
        return $info;
    }

}
