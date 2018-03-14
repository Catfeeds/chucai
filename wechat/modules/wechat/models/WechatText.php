<?php

namespace wechat\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "wechat_text".
 *
 * @property integer $id
 * @property string $content
 * @property string $create_time
 */
class WechatText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['create_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
