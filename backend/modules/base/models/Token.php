<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property string $id
 * @property string $token
 * @property integer $uid
 * @property string $start_time
 * @property string $end_time
 * @property integer $type
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'uid'], 'required'],
            [['uid', 'type'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['token'], 'string', 'max' => 48],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'token主键'),
            'token' => Yii::t('app', '用户凭证'),
            'uid' => Yii::t('app', '用户编号'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'type' => Yii::t('app', '登陆平台(0:未知,1:IOS,2:安卓,3:PC,4:手机)'),
        ];
    }
}
