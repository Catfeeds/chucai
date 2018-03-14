<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property integer $id
 * @property string $userphone
 * @property string $ip
 * @property integer $count
 * @property integer $platform
 * @property string $create_time
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'platform'], 'integer'],
            [['create_time'], 'safe'],
            [['userphone'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userphone' => Yii::t('app', 'Userphone'),
            'ip' => Yii::t('app', 'Ip'),
            'count' => Yii::t('app', '本日访问次数'),
            'platform' => Yii::t('app', '平台来源:1、PC 2、手机 '),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
