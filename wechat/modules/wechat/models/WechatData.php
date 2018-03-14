<?php

namespace wechat\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "wechat_data".
 *
 * @property integer $id
 * @property string $msg_type
 * @property string $to_user_name
 * @property string $from_user_name
 * @property string $content
 * @property string $msg_id
 * @property string $create_time
 * @property string $pic_url
 * @property string $media_id
 * @property string $format
 * @property string $recognition
 * @property string $thumb_media_id
 * @property string $location_x
 * @property string $location_y
 * @property string $scale
 * @property string $label
 * @property string $title
 * @property string $description
 * @property string $url
 */
class WechatData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['msg_id', 'media_id', 'thumb_media_id', 'scale'], 'integer'],
            [['create_time'], 'safe'],
            [['location_x', 'location_y'], 'number'],
            [['msg_type', 'format'], 'string', 'max' => 64],
            [['to_user_name', 'from_user_name', 'title'], 'string', 'max' => 128],
            [['pic_url', 'recognition', 'label', 'description'], 'string', 'max' => 256],
            [['url'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'msg_type' => Yii::t('app', 'Msg Type'),
            'to_user_name' => Yii::t('app', 'To User Name'),
            'from_user_name' => Yii::t('app', 'From User Name'),
            'content' => Yii::t('app', 'Content'),
            'msg_id' => Yii::t('app', 'Msg ID'),
            'create_time' => Yii::t('app', 'Create Time'),
            'pic_url' => Yii::t('app', 'Pic Url'),
            'media_id' => Yii::t('app', 'Media ID'),
            'format' => Yii::t('app', 'Format'),
            'recognition' => Yii::t('app', 'Recognition'),
            'thumb_media_id' => Yii::t('app', 'Thumb Media ID'),
            'location_x' => Yii::t('app', 'Location X'),
            'location_y' => Yii::t('app', 'Location Y'),
            'scale' => Yii::t('app', 'Scale'),
            'label' => Yii::t('app', 'Label'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
