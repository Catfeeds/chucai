<?php

namespace backend\modules\base\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "action_log".
 *
 * @property string $id
 * @property string $name
 * @property integer $uid
 * @property string $action_ip
 * @property string $title
 * @property string $remark
 * @property integer $type
 * @property integer $status
 * @property string $create_time
 * @property string $model
 * @property string $recorid
 *
 * @property User $u
 */
class ActionLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'type', 'status', 'recorid'], 'integer'],
            [['create_time'], 'safe'],
            [['name', 'action_ip', 'model'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 128],
            [['remark'], 'string', 'max' => 256],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键'),
            'name' => Yii::t('app', '操作名称'),
            'uid' => Yii::t('app', '操作用户'),
            'action_ip' => Yii::t('app', '访问ip'),
            'title' => Yii::t('app', '行为说明'),
            'remark' => Yii::t('app', '行为备注'),
            'type' => Yii::t('app', '类型'),
            'status' => Yii::t('app', '状态'),
            'create_time' => Yii::t('app', '操作时间'),
            'model' => Yii::t('app', '触发的表'),
            'recorid' => Yii::t('app', '触发数据主键'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
}
