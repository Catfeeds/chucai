<?php
/**
 * Created by PhpStorm.
 * User: Kshu<353817978@qq.com>
 * Date: 2017/3/1
 * Time: 20:24
 */

namespace wechat\models;

use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload($type=1)
    {
        switch ($type) {
            case 2:
            case 1:
            default :
                $base_file_name = 'wechat_img';
            break;
        }
        $filePath = $this->file->tempName;
        $key = getVerifyCode(16).'_'.time() . '.' . $this->file->extension;
        $result = Yii::$app->qiniu->putFile($base_file_name.'/'.$key, $this->file->tempName);
        if ($result['code'] === 0) {
            // 上传成功
//            $ret = $result['result']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg

            $ret['original'] = $this->file->name;
            $ret['type'] = $this->file->type;
            $ret['size'] = $this->file->size;
            $ret['url'] = $result['result']['url'];
            $ret['title'] = $key;
            $ret['state'] = 'success';
            $ret['md5'] = md5_file($filePath);
            $ret['sha1'] = sha1_file($filePath);
            $ret['originalname'] = $key;
            return $ret;
        } else {
            // 上传失败
//            $code = $ret['code']; // 错误码
//            $message = $ret['message']; // 错误信息
            return false;
        }
        
        die;
        $accessKey = "k2f9setoLpz6mSao4zTMSKmkbVH9hnxFwkhnv5gq";    //1pWwW7ZmnYIpJLpEeB_ZXs2Tkfe5nTLlFoyxcvPa
        $secretKey = "l_T1lApNbP8ZY154AE1w1i_wg6TFYt-1O7lRBvc7";    //n-Gx2HZoBt8VSzoZ-12I1euXzWmgjnp5O8g5L_5V
        $auth = new Auth($accessKey,$secretKey);

        $bucket = "hwtbucket";
        $token = $auth->uploadToken($bucket);
//        print_r($token);die;
        // 要上传文件的本地路径
        $filePath = $this->file->tempName;
        // 上传到七牛后保存的文件名
        $key = 'wechat_'. time() . '.' . $this->file->extension;
//        echo "uploadFile:{$filePath},对象名:{$key}";die;
        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return false;
//             var_dump($err);
        } else {
                
            $ret['original'] = $this->file->name;
            $ret['type'] = $this->file->type;
            $ret['size'] = $this->file->size;
            $ret['url'] = \Yii::getAlias('@imgurl').'/'.$key;
            $ret['title'] = $key;
            $ret['state'] = 'success';
            $ret['md5'] = md5_file($filePath);
            $ret['sha1'] = sha1_file($filePath);
            $ret['originalname'] = $key;
            return $ret;
     
        } 
    }
}