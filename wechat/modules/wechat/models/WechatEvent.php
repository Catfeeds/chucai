<?php

namespace wechat\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "wechat_event".
 *
 * @property integer $id
 * @property string $msg_type
 * @property string $to_user_name
 * @property string $from_user_name
 * @property string $event
 * @property integer $event_key
 * @property string $ticket
 * @property string $latitude
 * @property string $longitude
 * @property string $wx_precision
 * @property string $create_time
 */
class WechatEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_key'], 'integer'],
            [['latitude', 'longitude', 'wx_precision'], 'number'],
            [['create_time'], 'safe'],
            [['msg_type', 'event'], 'string', 'max' => 64],
            [['to_user_name', 'from_user_name'], 'string', 'max' => 128],
            [['ticket'], 'string', 'max' => 256],
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
            'event' => Yii::t('app', 'Event'),
            'event_key' => Yii::t('app', 'Event Key'),
            'ticket' => Yii::t('app', 'Ticket'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'wx_precision' => Yii::t('app', 'Wx Precision'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
