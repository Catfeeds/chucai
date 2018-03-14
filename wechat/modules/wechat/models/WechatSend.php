<?php

namespace wechat\modules\wechat\models;

use Yii;

/**
 * This is the model class for table "wechat_send".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $template_id
 * @property string $first_value
 * @property string $first_color
 * @property string $keyword1_value
 * @property string $keyword1_color
 * @property string $keyword2_value
 * @property string $keyword2_color
 * @property string $keyword3_value
 * @property string $keyword3_color
 * @property string $keyword4_value
 * @property string $keyword4_color
 * @property string $keyword5_value
 * @property string $keyword5_color
 * @property string $keyword6_value
 * @property string $keyword6_color
 * @property string $remark_value
 * @property string $remark_color
 */
class WechatSend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_send';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'template_id'], 'required'],
            [['name', 'first_color', 'keyword1_color', 'keyword2_color', 'keyword3_color', 'keyword4_color', 'keyword5_color', 'keyword6_color', 'remark_color'], 'string', 'max' => 64],
            [['url'], 'string', 'max' => 514],
            [['template_id'], 'string', 'max' => 256],
            [['first_value', 'keyword1_value', 'keyword2_value', 'keyword3_value', 'keyword4_value', 'keyword5_value', 'keyword6_value', 'remark_value'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '消息名称'),
            'url' => Yii::t('app', '跳转链接'),
            'template_id' => Yii::t('app', '模板'),
            'first_value' => Yii::t('app', '消息标题'),
            'first_color' => Yii::t('app', '标题字体颜色'),
            'keyword1_value' => Yii::t('app', '项目名称/姓名'),
            'keyword1_color' => Yii::t('app', '项目名称/姓名 字体颜色'),
            'keyword2_value' => Yii::t('app', '当前状态/项目介绍/手机号'),
            'keyword2_color' => Yii::t('app', '当前状态/项目介绍/手机号 字体颜色'),
            'keyword3_value' => Yii::t('app', '进度内容/团队标签/会员卡号'),
            'keyword3_color' => Yii::t('app', '进度内容/团队标签/会员卡号 字体颜色'),
            'keyword4_value' => Yii::t('app', '更新时间'),
            'keyword4_color' => Yii::t('app', '更新时间 字体颜色'),
            'keyword5_value' => Yii::t('app', '参数5（不填）'),
            'keyword5_color' => Yii::t('app', '字体颜色'),
            'keyword6_value' => Yii::t('app', '参数6（不填）'),
            'keyword6_color' => Yii::t('app', '字体颜色'),
            'remark_value' => Yii::t('app', '备注'),
            'remark_color' => Yii::t('app', '备注字体颜色'),
            'create_time' => Yii::t('app', '新增时间'),
        ];
    }
    
    /**
     * 获取菜单列表
     */
    public static function sendList(){
        $res_data = array();
        $modles = self::find()->orderBy('create_time desc')->all();
        foreach ($modles as $model) {
            $res_data[$model->id] = $model->name;
        }
        return $res_data;
    }
    
}
