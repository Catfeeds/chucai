<?php

namespace backend\modules\base\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property integer $id
 * @property string $title
 * @property string $remark
 * @property string $content
 * @property integer $sort
 * @property integer $type
 * @property string $action_id
 * @property integer $agency_id
 * @property string $create_time
 * @property string $update_time
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['sort', 'type', 'action_id', 'agency_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 64],
            [['remark'], 'string', 'max' => 140],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'remark' => Yii::t('app', '备注'),
            'content' => Yii::t('app', '富文本内容'),
            'sort' => Yii::t('app', '排序'),
            'type' => Yii::t('app', '位置： 1：推广技巧 2：奖励策略 3：常见问题'),
            'action_id' => Yii::t('app', '主键'),
            'agency_id' => Yii::t('app', '代理主键'),
            'create_time' => Yii::t('app', '发布时间'),
            'update_time' => Yii::t('app', '更新时间'),
        ];
    }
    public function beforeSave($insert)
    {
        $this->update_time = date('Y-m-d H:i:s',time());
        return parent::beforeSave($insert);
    }
}
