<?php
/**
 * Created by PhpStorm.
 * User: Kshu<353817978@qq.com>
 * Date: 2017/3/1
 * Time: 20:24
 */

namespace backend\models;

use Yii;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\base\Model;
use yii\web\UploadedFile;

class UeUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $upfile;

    public function rules()
    {
        return [
            [['upfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        $filePath = $this->upfile->tempName;
        $key = time() . '.' . $this->upfile->extension;
        $result = Yii::$app->qiniu->putFile('ueimg/'.$key, $this->upfile->tempName);
        if ($result['code'] === 0) {
            // 上传成功
//            $ret = $result['result']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg

            $ret['original'] = $this->upfile->name;
            $ret['type'] = $this->upfile->type;
            $ret['size'] = $this->upfile->size;
            $ret['url'] = $result['result']['url'];
            $ret['title'] = $key;
            $ret['state'] = 'SUCCESS';
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

    }
}