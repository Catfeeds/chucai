<?php

namespace backend\modules\base\controllers;

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
class PicApiController extends \yii\rest\Controller
{

    public function actionUploadOss()
    {
        $aliyun = new  Aliyunoss();
        $aliyun->test();
        $aliyun->upload('test1.jpg', 'D:/wamp/www/sass/backend/web/image/frontend_14890352273245.jpg');
        die;
    }
    //删除文件素材
    public function actionDelete(){
        return response();
    }

    public function actionUpload($pic_type='dev'){
        $req = Yii::$app->request;
        if (!$req->isPost) {
            throw new  HttpException(400);
        }

        $model = new Picture();
        /**
         * 将图片存入素材库
         * @var unknown
         */
        $getdata  = $this->picuploadlocal();
        if (empty($getdata))
        {
            return response(20001,'上传失败，请刷新重试',$getdata);
        }

        if ($pic_type == 'local')
        {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $getdata;
        }
        return response(0,'success'.$pic_type,$getdata);
        if (empty($getdata))
        {
            return response(20001,'上传失败，请刷新重试',$getdata);
        }
        elseif (!empty($getdata['is_exit']))
        {
            if ($pic_type == 'local')
            {
//                 $getdata['url'] = $getdata['title'];
            }
            return $getdata;
        }
//         $getdata['type'] = 'image';
        $model->setAttributes($getdata);
        if ($model->validate() && $model->save())
        {
            if ($pic_type == 'local')
            {
//                 $getdata['url'] = $getdata['title'];
            }
            return $getdata;
        }




    }
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

    /**
     * 处理图片的上传
     */
    protected function picuploadlocal($file='file',$model=FALSE)
    {
        $config = [
            'savePath' => \Yii::getAlias('@webroot/image/'), //存储文件夹
            'maxSize' => 1024*5 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];

        $up = new Uploader($file, $config, 'frontend',$model);


        $info = $up->getFileInfo();
        return $info;
    }


    /**
     * 处理图片的上传
     */
    protected function picupload($model=FALSE)
    {
        $model = new UploadForm();
        $resdata = [];

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstanceByName('file');
//             print_r($model->file);die;
            /**
             * 先验证文件是否存在
             * @var unknown
             */
            $ret['md5'] = md5_file($model->file->tempName);
            $ret['sha1'] = sha1_file($model->file->tempName);
            $picModel = Picture::findOne(['md5'=>$ret['md5'],'sha1'=>$ret['sha1']]);
            if (!empty($picModel))
            {
                $resdata['original'] = $picModel->originalname;
                $resdata['type'] = $picModel->type;
                $resdata['size'] = 0;
                $resdata['url'] = $picModel->url;
                $resdata['title'] = $picModel->originalname;
                $resdata['state'] = 'success';
                $resdata['md5'] = $picModel->md5;
                $resdata['sha1'] = $picModel->sha1;
                $resdata['originalname'] = $picModel->originalname;
                $resdata['is_exit'] = true;
                return $resdata;
            }


            $resdata = $model->upload();
        }
        return $resdata;
    }
}
