<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "picture".
 *
 * @property string $id
 * @property string $type
 * @property string $path
 * @property string $url
 * @property string $md5
 * @property string $sha1
 * @property integer $status
 * @property string $create_time
 * @property integer $width
 * @property integer $height
 * @property string $originalname
 */
class Picture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'width', 'height'], 'integer'],
            [['create_time'], 'safe'],
            [['type'], 'string', 'max' => 50],
            [['path', 'url'], 'string', 'max' => 255],
            [['md5'], 'string', 'max' => 32],
            [['sha1'], 'string', 'max' => 40],
            [['originalname'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键id自增'),
            'type' => Yii::t('app', 'Type'),
            'path' => Yii::t('app', '路径'),
            'url' => Yii::t('app', '图片链接'),
            'md5' => Yii::t('app', '文件md5'),
            'sha1' => Yii::t('app', '文件 sha1编码'),
            'status' => Yii::t('app', '状态'),
            'create_time' => Yii::t('app', '创建时间'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'originalname' => Yii::t('app', '上传文件名'),
        ];
    }
}
